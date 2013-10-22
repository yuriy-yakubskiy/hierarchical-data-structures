drop table "menutest";

CREATE TABLE "menutest" (
    "id" serial PRIMARY KEY,
    "name" character varying(255),
    "parentid" integer
);

ALTER TABLE "menutest" ADD CONSTRAINT "menutest_id_parentid"
    FOREIGN key ("parentid") REFERENCES "menutest" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

drop function buildMenu( "maxlevel" int, "parentid" int, "level" int, "childscount" int );

CREATE OR REPLACE FUNCTION buildMenu( "maxlevel" int, "parentid" int, "level" int, "childscount" int ) RETURNS integer AS
$BODY$
DECLARE
    "tmp_parent_id" int;
BEGIN
    "level" = "level" + 1;

    if "level" > "maxlevel" then
        return 1;
    end if;

    FOR "i" IN 1.."childscount"
    LOOP
         INSERT INTO "menutest" ( "name", "parentid" ) VALUES( 'element', "parentid" );
         select into "tmp_parent_id" max("id") from "menutest";
         perform * from buildMenu( "maxlevel", "tmp_parent_id", "level", "childscount" );
    END LOOP;

    RETURN 1;
END
$BODY$
LANGUAGE 'plpgsql' ;

select * from buildMenu( 7, null, 0, 5 );
