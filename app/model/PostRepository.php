<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 1. 8. 2016
 * Time: 12:12
 */

namespace App\Model;


use Nette\Neon\Exception;

class PostRepository extends Repository
{
    protected $table = "post";

    public function add($userId, $threadId, $content, $parentId = null)
    {
        $data = array('user_id'     => $userId,
                      'thread_id'   => $threadId,
                      'content'     => $content);

        if ($parentId) {
            $data['reply_to_id'] = $parentId;
        }

        if (!$parentId) {
            $this->database->query('
              INSERT INTO post ?;
              
              UPDATE post SET path = CONCAT(LPAD(LAST_INSERT_ID(),8,\'0\'),\'/\'),
                              depth = 1
                    WHERE id = LAST_INSERT_ID();', $data);
        } else {
            $parent = $parent = $this->get($parentId);
            $parentDepth = $parent->depth;
            while ($parentDepth > 2) {
                $parent = $this->get($parent->parent_id);

                $parentId = $parent->id;
                $parentDepth = $parent->depth;
            }

            $data['parent_id'] = $parentId;

            $this->database->query('
              INSERT INTO post ?;
              SELECT @new_path := concat(path,LPAD(LAST_INSERT_ID(),8,\'0\'),\'/\') 
                FROM post p WHERE p.id = ?;

              UPDATE post
                SET path = @new_path,
                    depth = LENGTH(path) - LENGTH(REPLACE(path,\'/\',\'\'))
                WHERE id = LAST_INSERT_ID();
            ', $data, $parentId);


        }
        $id = $this->database->query('SELECT LAST_INSERT_ID() as id FROM post LIMIT 1')->fetch()['id'];
        return $id;
    }
}