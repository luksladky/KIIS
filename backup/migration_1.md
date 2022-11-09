ALTER TABLE `event`
	ADD COLUMN `event_type` VARCHAR(20) NULL DEFAULT 'public' AFTER `user_id`;
