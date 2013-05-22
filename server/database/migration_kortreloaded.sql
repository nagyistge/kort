drop if exists view kort.aggregateddata_from_all_missions;
drop if exists  view kort.aggregateddata_from_all_validations;
drop if exists  view kort.all_missions_with_promotions;
drop if exists  view kort.all_validations_with_promotions;
drop if exists  view kort.all_running_promotions;
drop if exists  view kort.validations;
drop if exists  view kort.all_fixes;
drop if exists  view kort.errors;
drop if exists  view kort.all_errors;
drop if exists  view kort.error_types;
drop if exists  view kort.user_model;
drop if exists  view kort.highscore;
drop if exists  view kort.language;
drop if exists  view kort.relationtype;
drop if exists  view kort.religion;
drop if exists  view kort.select_answer;
drop if exists  view kort.statistics;
drop if exists  view kort.user_badges;

ALTER TABLE kort.fix ALTER COLUMN error_id TYPE bigint USING error_id::bigint;
ALTER TABLE kort.fix ALTER COLUMN osm_id TYPE bigint USING osm_id::bigint;