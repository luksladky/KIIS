<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 29. 7. 2018
 * Time: 22:35
 */

namespace App\Model;

use Nette,
    Nette\Http\FileUpload,
    Nette\Utils\FileSystem;

use WebChemistry\Images;

use WebChemistry\Images\ImageStorageException;

class FileRepository extends Repository
{
    protected $table = 'file';

    const IMAGE_NAMESPACE = 'files_images';
    const FILES_NAMESPACE = 'files';

    const IMAGE_TYPE = 'image';
    const GENERAL_TYPE = 'file';
    /** @var Images\FileStorage\FileStorage */
    protected $imageStorage;


    /** Required for proper work, upload functions will throw exceptions if not setted.
     * @param Images\AbstractStorage $imageStorage
     */
    public function setImageStorage(Images\AbstractStorage $imageStorage)
    {
        $this->imageStorage = $imageStorage;
    }


    public function insertFile(FileUpload $file, $objectId, $objectType, $userId)
    {
        $filename = $objectId . '_' . time(). '_'. $file->getSanitizedName();
        if ($file->isImage()) {
            $namespacePath = self::IMAGE_NAMESPACE . '/' . $filename;;
            $type = self::IMAGE_TYPE;

            $photo = $this->imageStorage->createImage();
            try {
                $photo->setName($filename)
                    ->setNamespace('files_images')
                    ->saveUpload($file);
            } catch (ImageStorageException $e) {
                dump($e);
            }
        } else {
            $namespacePath = self::FILES_NAMESPACE . '/' . $filename;
            $type = self::GENERAL_TYPE;
            $file->move('assets/' . $namespacePath);
        }


        $data = ['filename'         => $namespacePath,
                 'original_filename' => $file->getName(),
                 'type'             => $type,
                 'size'             => $file->getSize(),
                 'user_id'          => $userId,
                 'object_id'        => $objectId,
                 'object_type'      => $objectType];

        $this->insert($data);
    }

    public function findFor($objectId, $objectType) {
        return $this->findBy(['object_id' => $objectId, 'object_type' => $objectType]);
    }

    public function deleteByObject($objectId, $objectType) {
        $files = $this->findBy(['object_id' => $objectId, 'object_type' => $objectType]);

        $this->deleteFiles($files);
    }

    public function deleteByObjectMulti($objectIds, $objectType) {
        $files = $this->findBy("(object_id IN ?) AND (object_type = ?)",[$objectIds, $objectType]);

        $this->deleteFiles($files);
    }

    private function deleteFiles(Nette\Database\Table\Selection $files) {
        foreach ($files as $file) {
            if ($file->type == 'image') {
                $this->imageStorage->delete($file->filename);
            } else {
                FileSystem::delete('assets/' . $file->filename);
            }
        }

        $files->delete();
    }
}