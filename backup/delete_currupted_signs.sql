#DELETE SIGNS WITH NO RELATION TO EVENT
DELETE FROM user_event
WHERE ID IN (SELECT * FROM (SELECT id
             FROM user_event
             WHERE user_event.role_id NOT IN (SELECT event_role.role_id
                                              FROM event_role
                                              WHERE event_role.event_id = user_event.event_id))as t);
