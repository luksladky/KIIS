# USERS
INSERT INTO user
(id,nickname,user.email,name,hash_old,phone,city,last_activity)
  SELECT
    ID as id,
    PREZDIVKA as nickname,
    EMAIL as mail,
    CONCAT(JMENO,' ',PRIJMENI) as name,
    HESLO as hash_old,
    TELEFON as phone,
    MESTO as city,
  IF(AKTIVITA > 0,FROM_UNIXTIME(AKTIVITA),FROM_UNIXTIME(1)) as last_activity
  FROM KONTAKTY WHERE KONTAKTY.ID > 0;

#PERMISSIONS
INSERT INTO user_permission
(user_id, permission_slug)
SELECT user.id as user_id , 'member' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname
UNION
SELECT user.id as user_id , 'add-event' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_AKCE = 'ANO'
UNION
SELECT user.id as user_id , 'add-thread' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_DISKUSE = 'ANO'
UNION
SELECT user.id as user_id , 'modify-user' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_PRAVA = 'ANO'
UNION
SELECT user.id as user_id , 'manage-threads' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_PRAVA = 'ANO'
UNION
SELECT user.id as user_id , 'manage-events' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_PRAVA = 'ANO'
UNION
SELECT user.id as user_id , 'modify-homepage' FROM KONTAKTY JOIN user ON PREZDIVKA = user.nickname WHERE IS_PRAVA = 'ANO';

#admin rights for me
INSERT INTO user_permission
(user_id, permission_slug) SELECT user.id, 'modify-user' FROM user WHERE user.email = 'lusladky@gmail.com';

#approve all users by admin
UPDATE user SET approved_by_id = (SELECT * FROM (SELECT user.id FROM user WHERE user.email = 'lusladky@gmail.com' LIMIT 1) as t);



#EVENTS
INSERT INTO event
(id,title,event.description,date_from,date_to,user_id)
    SELECT AKCE.id, nazev, text, FROM_UNIXTIME(od), FROM_UNIXTIME(do), user.id as user_id

      FROM AKCE LEFT JOIN user ON AKCE.autor = user.nickname;

UPDATE event SET date_from = ADDTIME(date_from,'00:00:01'), date_to = ADDTIME(date_to,'12:00:00') WHERE HOUR(date_to) = 0;


#THREADS
INSERT INTO thread
(id,title,user_id,created_at,archived,pinned)

SELECT
  VLAKNA.id, nazev, user.id as user_id, FROM_UNIXTIME(CAS),
  IF(SKRYTO = 'ANO' , 1 , 0) as archived,
  IF(PRIPNUTO = 'ANO' , 1 , 0) as pinned
FROM VLAKNA LEFT JOIN user ON VLAKNA.autor = user.nickname
WHERE AKCE = 'NE';

#THREADS ON EVENTS
INSERT INTO thread
(id,title,user_id,created_at,archived,pinned,event_id)
  SELECT
    VLAKNA.id, VLAKNA.nazev, user.id as user_id, FROM_UNIXTIME(CAS) as created_at,
    IF(SKRYTO = 'ANO' , 1 , 0) as hidden,
    IF(PRIPNUTO = 'ANO' , 1 , 0) as pinned,
    tAKCE.event_id as event_id
  FROM VLAKNA
    JOIN user ON VLAKNA.autor = user.nickname
    JOIN (SELECT MAX(id) as event_id,nazev from AKCE GROUP BY NAZEV) as tAKCE ON VLAKNA.NAZEV = tAKCE.NAZEV
  WHERE VLAKNA.AKCE = 'ANO';

# SELECT * FROM VLAKNA WHERE AKCE = 'ANO';
# SELECT MAX(id) as id,nazev from AKCE GROUP BY NAZEV;
# SELECT * FROM AKCE;
#SELECT COUNT(id) as id,nazev from AKCE GROUP BY NAZEV HAVING count(id) > 1

#RESTRICTIONS
INSERT INTO thread_hidden_user
(user_id, thread_id)
SELECT t.user_id, t.thread_id FROM (SELECT user.id as user_id, ID_VLAKNA as thread_id
FROM DISKUSE_CASY JOIN user ON user.nickname = PREZDIVKA WHERE CAS = 0) as t JOIN thread ON thread_id = thread.id;


#POSTS
INSERT INTO post
(id,thread_id,user_id,post.content,created_at,path)
SELECT t.* FROM (SELECT PRISPEVKY.id as id,ID_VLAKNA as thread_id,user.id as user_id,text as content,from_unixtime(CAS) as created_at,
CONCAT(LPAD(PRISPEVKY.id,8,'0'),'/') as path
FROM PRISPEVKY LEFT JOIN user ON PRISPEVKY.autor = user.nickname WHERE user.id IS NOT NULL
UNION
SELECT PRISPEVKY.id as id,ID_VLAKNA as thread_id,1 as user_id,text as content,from_unixtime(CAS) as created_at,
CONCAT(LPAD(PRISPEVKY.id,8,'0'),'/') as path
FROM PRISPEVKY LEFT JOIN user ON PRISPEVKY.autor = user.nickname WHERE user.id IS NULL ORDER BY id) as t JOIN thread on thread.id = thread_id;

#LAST POST DATES
UPDATE thread as t1 JOIN thread as t2
ON t1.id = t2.id SET t1.last_post = t2.created_at;

UPDATE thread as t1 JOIN (SELECT max(created_at) as last_post, thread_id as id FROM post GROUP BY thread_id) as t2
ON t1.id = t2.id SET t1.last_post = t2.last_post;

#POST DEPTH
UPDATE post set depth = 1 WHERE depth IS NULL;

#ACTIVITY
INSERT INTO activity
(thread_id,user_id,last_activity,activity_type)
  SELECT t.* FROM (SELECT ID_VLAKNA as thread_id,user.id as user_id,from_unixtime(cas) as last_activity, 'seen' as activity_type
    FROM DISKUSE_CASY LEFT JOIN user ON DISKUSE_CASY.PREZDIVKA = user.nickname WHERE cas > 10000000 AND user.id IS NOT NULL) as t JOIN thread ON t.thread_id = thread.id;

#BB codes
# UPDATE post SET content = replace(content, '[n]', '\r\n');
UPDATE post SET content = replace(content, '[n]', '<br>');
UPDATE post SET content = replace(content, '[b]', '<b>');
UPDATE post SET content = replace(content, '[/b]', '</b>');
UPDATE post SET content = replace(content, '[i]', '<i>');
UPDATE post SET content = replace(content, '[/i]', '</i>');
UPDATE post SET content = replace(content, '[u]', '<u>');
UPDATE post SET content = replace(content, '[/u]', '</u>');
UPDATE post SET content = replace(content, '[s]', '<s>');
UPDATE post SET content = replace(content, '[/s]', '</s>');
UPDATE post SET content = replace(content, '[sub]', '<sub>');
UPDATE post SET content = replace(content, '[/sub]', '</sub>');
UPDATE post SET content = replace(content, '[sup]', '<sup>');
UPDATE post SET content = replace(content, '[/sup]', '</sup>');
UPDATE post SET content = replace(content, '[hr]', '<hr>');
UPDATE post SET content = replace(content, '[url ', '<a target=\"_blank\" href="');
UPDATE post SET content = replace(content, '[/url]', '</a>');
UPDATE post SET content = replace(content, '#]', '"> ');
UPDATE post SET content = replace(content, '$]', '"> ');
UPDATE post SET content = replace(content, '%]', '"> ');
UPDATE post SET content = replace(content, '[color ', '<span style="color:');
UPDATE post SET content = replace(content, '[/color]', '</span>');
UPDATE post SET content = replace(content, '[seznam]', '</ul>');
UPDATE post SET content = replace(content, '[/seznam]', '</ul>');
UPDATE post SET content = replace(content, '[bod]', '<li>');
UPDATE post SET content = replace(content, '[/bod]', '</li>');
UPDATE post SET content = replace(content, '"<', '<');
UPDATE post SET content = replace(content, '[center]', '<p style=\"text-align:center;\">');
UPDATE post SET content = replace(content, '[/center]', '</p>');

# SELECT * FROM post WHERE content LIKE '%<b>%' AND post.content NOT LIKE '%</b>%';
# UPDATE post SET content = replace(content, '<seznam>', '<ul>');
# UPDATE post SET content = replace(content, '</seznam>', '</ul>');

UPDATE post SET content = replace(replace(content,'</b>',''),'<b>','')
WHERE  LENGTH(REPLACE(content, '</b>', '<c>')) - LENGTH(REPLACE(content, '</b>', '')) <> LENGTH(REPLACE(content, '</b>', '<c>')) - LENGTH(REPLACE(content, '<b>', ''))
# SELECT content FROM post
# WHERE  LENGTH(REPLACE(content, '</b>', '<c>')) - LENGTH(REPLACE(content, '</b>', '')) <> LENGTH(REPLACE(content, '</b>', '<c>')) - LENGTH(REPLACE(content, '<b>', ''))

#EVENTS BBCODE
UPDATE event SET description = replace(description, '[n]', '<br>');
UPDATE event SET description = replace(description, '[b]', '<b>');
UPDATE event SET description = replace(description, '[/b]', '</b>');
UPDATE event SET description = replace(description, '[i]', '<i>');
UPDATE event SET description = replace(description, '[/i]', '</i>');
UPDATE event SET description = replace(description, '[u]', '<u>');
UPDATE event SET description = replace(description, '[/u]', '</u>');
UPDATE event SET description = replace(description, '[s]', '<s>');
UPDATE event SET description = replace(description, '[/s]', '</s>');
UPDATE event SET description = replace(description, '[sub]', '<sub>');
UPDATE event SET description = replace(description, '[/sub]', '</sub>');
UPDATE event SET description = replace(description, '[sup]', '<sup>');
UPDATE event SET description = replace(description, '[/sup]', '</sup>');
UPDATE event SET description = replace(description, '[hr]', '<hr>');
UPDATE event SET description = replace(description, '[url ', '<a target=\"_blank\" href="');
UPDATE event SET description = replace(description, '[/url]', '</a>');
UPDATE event SET description = replace(description, '#]', '"> ');
UPDATE event SET description = replace(description, '$]', '"> ');
UPDATE event SET description = replace(description, '%]', '"> ');
UPDATE event SET description = replace(description, '[color ', '<span style="color:');
UPDATE event SET description = replace(description, '[/color]', '</span>');
UPDATE event SET description = replace(description, '[seznam]', '</ul>');
UPDATE event SET description = replace(description, '[/seznam]', '</ul>');
UPDATE event SET description = replace(description, '[bod]', '<li>');
UPDATE event SET description = replace(description, '[/bod]', '</li>');
UPDATE event SET description = replace(description, '"<', '<');
UPDATE event SET description = replace(description, '[center]', '<p style=\"text-align:center;\">');
UPDATE event SET description = replace(description, '[/center]', '</p>');



DROP TABLE
KIIS_CLIENT_ANAYLTICS,KIIS_DISCUSSIONS_TIMES,
KIIS_ERROR_REPORT,KIIS_EVENT_APPLICATION,KIIS_EVENT_FEEDBACK,KIIS_EVENTS,KIIS_LOG,KIIS_POSTS,
KIIS_REGISTRATION,KIIS_SERVER_MESSAGES,KIIS_SETTINGS,KIIS_THREAD_LOCK,KIIS_THREADS,KIIS_USERS,
AKCE,ANTIBOT_QUESTIONS,DISKUSE_CASY,KONTAKTY,PRISPEVKY,REGISTRACE,
UZIVATELE,VLAKNA;