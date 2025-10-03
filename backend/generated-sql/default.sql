
BEGIN;

-----------------------------------------------------------------------
-- album
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "album" CASCADE;

CREATE TABLE "album"
(
    "album_id" serial NOT NULL,
    "title" VARCHAR(160) NOT NULL,
    "artist_id" INTEGER NOT NULL,
    PRIMARY KEY ("album_id")
);

CREATE INDEX "album_artist_id_idx" ON "album" ("artist_id");

-----------------------------------------------------------------------
-- artist
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "artist" CASCADE;

CREATE TABLE "artist"
(
    "artist_id" serial NOT NULL,
    "name" VARCHAR(120),
    PRIMARY KEY ("artist_id")
);

-----------------------------------------------------------------------
-- customer
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "customer" CASCADE;

CREATE TABLE "customer"
(
    "customer_id" serial NOT NULL,
    "first_name" VARCHAR(40) NOT NULL,
    "last_name" VARCHAR(20) NOT NULL,
    "company" VARCHAR(80),
    "address" VARCHAR(70),
    "city" VARCHAR(40),
    "state" VARCHAR(40),
    "country" VARCHAR(40),
    "postal_code" VARCHAR(10),
    "phone" VARCHAR(24),
    "fax" VARCHAR(24),
    "email" VARCHAR(60) NOT NULL,
    "support_rep_id" INTEGER,
    PRIMARY KEY ("customer_id")
);

CREATE INDEX "customer_support_rep_id_idx" ON "customer" ("support_rep_id");

-----------------------------------------------------------------------
-- employee
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "employee" CASCADE;

CREATE TABLE "employee"
(
    "employee_id" serial NOT NULL,
    "last_name" VARCHAR(20) NOT NULL,
    "first_name" VARCHAR(20) NOT NULL,
    "title" VARCHAR(30),
    "reports_to" INTEGER,
    "birth_date" TIMESTAMP,
    "hire_date" TIMESTAMP,
    "address" VARCHAR(70),
    "city" VARCHAR(40),
    "state" VARCHAR(40),
    "country" VARCHAR(40),
    "postal_code" VARCHAR(10),
    "phone" VARCHAR(24),
    "fax" VARCHAR(24),
    "email" VARCHAR(60),
    PRIMARY KEY ("employee_id")
);

CREATE INDEX "employee_reports_to_idx" ON "employee" ("reports_to");

-----------------------------------------------------------------------
-- genre
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "genre" CASCADE;

CREATE TABLE "genre"
(
    "genre_id" serial NOT NULL,
    "name" VARCHAR(120),
    PRIMARY KEY ("genre_id")
);

-----------------------------------------------------------------------
-- invoice
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "invoice" CASCADE;

CREATE TABLE "invoice"
(
    "invoice_id" serial NOT NULL,
    "customer_id" INTEGER NOT NULL,
    "invoice_date" TIMESTAMP NOT NULL,
    "billing_address" VARCHAR(70),
    "billing_city" VARCHAR(40),
    "billing_state" VARCHAR(40),
    "billing_country" VARCHAR(40),
    "billing_postal_code" VARCHAR(10),
    "total" NUMERIC(10,2) NOT NULL,
    PRIMARY KEY ("invoice_id")
);

CREATE INDEX "invoice_customer_id_idx" ON "invoice" ("customer_id");

-----------------------------------------------------------------------
-- invoice_line
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "invoice_line" CASCADE;

CREATE TABLE "invoice_line"
(
    "invoice_line_id" serial NOT NULL,
    "invoice_id" INTEGER NOT NULL,
    "track_id" INTEGER NOT NULL,
    "unit_price" NUMERIC(10,2) NOT NULL,
    "quantity" INTEGER NOT NULL,
    PRIMARY KEY ("invoice_line_id")
);

CREATE INDEX "invoice_line_invoice_id_idx" ON "invoice_line" ("invoice_id");

CREATE INDEX "invoice_line_track_id_idx" ON "invoice_line" ("track_id");

-----------------------------------------------------------------------
-- media_type
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "media_type" CASCADE;

CREATE TABLE "media_type"
(
    "media_type_id" serial NOT NULL,
    "name" VARCHAR(120),
    PRIMARY KEY ("media_type_id")
);

-----------------------------------------------------------------------
-- playlist
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "playlist" CASCADE;

CREATE TABLE "playlist"
(
    "playlist_id" serial NOT NULL,
    "name" VARCHAR(120),
    PRIMARY KEY ("playlist_id")
);

-----------------------------------------------------------------------
-- playlist_track
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "playlist_track" CASCADE;

CREATE TABLE "playlist_track"
(
    "playlist_id" INTEGER NOT NULL,
    "track_id" INTEGER NOT NULL,
    PRIMARY KEY ("playlist_id","track_id")
);

CREATE INDEX "playlist_track_playlist_id_idx" ON "playlist_track" ("playlist_id");

CREATE INDEX "playlist_track_track_id_idx" ON "playlist_track" ("track_id");

-----------------------------------------------------------------------
-- track
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "track" CASCADE;

CREATE TABLE "track"
(
    "track_id" serial NOT NULL,
    "name" VARCHAR(200) NOT NULL,
    "album_id" INTEGER,
    "media_type_id" INTEGER NOT NULL,
    "genre_id" INTEGER,
    "composer" VARCHAR(220),
    "milliseconds" INTEGER NOT NULL,
    "bytes" INTEGER,
    "unit_price" NUMERIC(10,2) NOT NULL,
    PRIMARY KEY ("track_id")
);

CREATE INDEX "track_album_id_idx" ON "track" ("album_id");

CREATE INDEX "track_genre_id_idx" ON "track" ("genre_id");

CREATE INDEX "track_media_type_id_idx" ON "track" ("media_type_id");

ALTER TABLE "album" ADD CONSTRAINT "album_artist_id_fkey"
    FOREIGN KEY ("artist_id")
    REFERENCES "artist" ("artist_id");

ALTER TABLE "customer" ADD CONSTRAINT "customer_support_rep_id_fkey"
    FOREIGN KEY ("support_rep_id")
    REFERENCES "employee" ("employee_id");

ALTER TABLE "employee" ADD CONSTRAINT "employee_reports_to_fkey"
    FOREIGN KEY ("reports_to")
    REFERENCES "employee" ("employee_id");

ALTER TABLE "invoice" ADD CONSTRAINT "invoice_customer_id_fkey"
    FOREIGN KEY ("customer_id")
    REFERENCES "customer" ("customer_id");

ALTER TABLE "invoice_line" ADD CONSTRAINT "invoice_line_invoice_id_fkey"
    FOREIGN KEY ("invoice_id")
    REFERENCES "invoice" ("invoice_id");

ALTER TABLE "invoice_line" ADD CONSTRAINT "invoice_line_track_id_fkey"
    FOREIGN KEY ("track_id")
    REFERENCES "track" ("track_id");

ALTER TABLE "playlist_track" ADD CONSTRAINT "playlist_track_playlist_id_fkey"
    FOREIGN KEY ("playlist_id")
    REFERENCES "playlist" ("playlist_id");

ALTER TABLE "playlist_track" ADD CONSTRAINT "playlist_track_track_id_fkey"
    FOREIGN KEY ("track_id")
    REFERENCES "track" ("track_id");

ALTER TABLE "track" ADD CONSTRAINT "track_album_id_fkey"
    FOREIGN KEY ("album_id")
    REFERENCES "album" ("album_id");

ALTER TABLE "track" ADD CONSTRAINT "track_genre_id_fkey"
    FOREIGN KEY ("genre_id")
    REFERENCES "genre" ("genre_id");

ALTER TABLE "track" ADD CONSTRAINT "track_media_type_id_fkey"
    FOREIGN KEY ("media_type_id")
    REFERENCES "media_type" ("media_type_id");

COMMIT;
