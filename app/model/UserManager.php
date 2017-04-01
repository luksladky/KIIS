<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Nette\Utils\Strings;


/**
 * Authenticator and Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{
    const
        TABLE = 'user';
    const COL_TOKEN_RESET = 'reset_token',
        COL_TOKEN_REGISTRATION = 'registration_token';
    const DUPLICIT_IDENTIFICATOR = 5;


    /** @var Nette\Database\Context */
    private $database;

    /** @var  ProfileRepository */
    public $profileRepository;

    // /** @var  \WebChemistry\Images\AbstractStorage */
    //private $imageStorage;

    public function __construct(Nette\Database\Context $database, ProfileRepository $profileRepository)
    {
        $this->database = $database;
        $this->profileRepository = $profileRepository;
    }

    ///**
    // * @param \WebChemistry\Images\AbstractStorage $imageStorage
    // */
    //public function setImageStorage($imageStorage)
    //{
    //    $this->imageStorage = $imageStorage;
    //}


    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($email, $password) = $credentials;

        $row = $this->database->table(self::TABLE)->where('email', $email)->fetch();

        if (!$row) {
            $row = $this->database->table(self::TABLE)->where('nickname', $email);
            if (!$row) {
                throw new Nette\Security\AuthenticationException('Nesprávný email nebo heslo.', self::IDENTITY_NOT_FOUND);
            } elseif ($row->count() > 1) {
                throw new Nette\Security\AuthenticationException('Tuto přezdívku používá víc lidí.', self::IDENTITY_NOT_FOUND);
            }
            $row = $row->fetch();
        }

        if ($row['hash_old']) {
            if ($row['hash_old'] !== md5($password . 'KIIS')) {
                throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
            }

            $row->update(array(
                'hash_old' => null,
                'hash'     => Passwords::hash($password),
            ));

        } elseif (!Passwords::verify($password, $row['hash'])) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($row['hash'])) {
            $row->update(array(
                'hash' => Passwords::hash($password),
            ));
        }

        if ($row['logout']) $row->update(['logout' => 0]);

        $arr = $row->toArray();
        $arr['confirmed'] = is_null($arr['registration_token']);
        unset($arr['hash']);
        unset($arr['reset_token']);
        unset($arr['registration_token']);

        $roles = $this->database->table('user_permission')->where('user_id', $row['id'])->fetchPairs(null, 'permission_slug');
        return new Nette\Security\Identity($row['id'], $roles, $arr);
    }


    /**Adds new user.
     * @param $nickname
     * @param $name
     * @param $email
     * @param $password
     * @return string
     * @throws DuplicateNameException
     */
    public function add($email, $password, $nickname, $name)
    {
        $hash = Passwords::hash($password);

        $token = $this->generateUniqueToken('registration_token', 30);

        try {
            $this->database->table(self::TABLE)->insert(array(
                'nickname'           => $nickname,
                'name'               => $name,
                'email'              => $email,
                'hash'               => $hash,
                'registration_token' => $token,
            ));
            return $token;
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new DuplicateNameException;
        }
    }

    /**
     * @param $userId
     * @return string
     */
    public function getRegistrationToken($userId)
    {
        return $this->database->table(self::TABLE)->get($userId)['registration_token'];
    }

    /**Tries to update role of user with given token, returns (bool) success.
     * @param $token
     * @return bool
     */
    public function confirmRegistration($token)
    {
        return $this->database->table(self::TABLE)->where('registration_token', $token)
            ->update(['registration_token' => null]) == 1;
    }

    /** Generates reset password key to be send via email
     * @param $email
     * @return string
     */
    public function generateResetPasswordToken($email)
    {
        $user = $this->database->table(self::TABLE)->where('email', $email);
        $token = $this->generateUniqueToken('reset_token');
        $user->update(['reset_token' => $token]);
        return $token;
    }

    /**Check if token and email match
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function validateResetPasswordToken($email, $token)
    {
        $row = $this->database->table(self::TABLE)->where('reset_token', $token);
        $data = $row->fetch();

        return $row->count() === 1 && Strings::webalize($data['email']) == Strings::webalize($email);
    }

    /**Remove reset token (when used or expired)
     * @param string $token
     * @return bool
     */
    public function invalidateResetPasswordToken($token)
    {
        return $this->database->table(self::TABLE)->where('reset_token', $token)
            ->update(['reset_token' => null]) == 1;
    }

    /**Changes users password, verifies if oldPassword match current (optional)
     * @param $userId
     * @param $newPassword
     * @param null $oldPassword
     * @return bool
     * @throws Nette\Application\BadRequestException
     */
    public function changePassword($userId, $newPassword, $oldPassword = null)
    {
        $row = $this->database->table(self::TABLE)->where('id', $userId);
        $user = $row->fetch();
        if ($user == null)
            throw new Nette\Application\BadRequestException('User with that id doesn\'t exist');

        if (isset($user['hash']))
            if (isset($oldPassword)) {
                if (!Nette\Security\Passwords::verify($oldPassword, $user['hash'])) {
                    return false;
                }
            } else
                throw new Nette\Application\BadRequestException('Old password not specified');

        $row->update(['hash'     => Nette\Security\Passwords::hash($newPassword),
                      'hash_old' => null]);
        return true;
    }

    /**Change password for user with given (unique) token.
     * @param $resetToken
     * @param $newPassword
     * @return bool
     */
    public function resetPassword($resetToken, $newPassword)
    {
        $row = $this->database->table(self::TABLE)->where('reset_token', $resetToken);
        $user = $row->fetch();

        if ($user == null)
            return false;

        $row->update(['hash' => Nette\Security\Passwords::hash($newPassword), 'reset_token' => null]);
        return true;

    }

    public function getCalendarExportToken($userId)
    {

        $user = $this->profileRepository->get($userId);

        $token = $user['calendar_token'];

        if ($token == null) {
            $token = $this->generateUniqueToken('calendar_token');
            $user->update(['calendar_token' => $token]);
        }

        return $token;
    }

    /**Generates unique random key in given column.
     * @param $column
     * @param int $length
     * @return string
     */
    private function generateUniqueToken($column, $length = 50)
    {
        do {
            $token = Nette\Utils\Random::generate($length);
        } while ($this->database->table(self::TABLE)->where($column, $token)->fetch() != null);

        return $token;
    }


}


class DuplicateNameException extends \Exception
{
}
