USE base;

-- Створюємо таблицю для регіонів
CREATE TABLE regions
(
    region_id      INT AUTO_INCREMENT PRIMARY KEY,
    region_name_uk VARCHAR(142) NOT NULL UNIQUE,
    region_name_ru VARCHAR(142) NOT NULL UNIQUE
);

-- Вставка унікальних регіонів з початкової таблиці
INSERT INTO regions (region_name_uk, region_name_ru)
SELECT DISTINCT region_name_uk, region_name_ru
FROM catalog_city;

-- Створюємо таблицю для унікальних районів
CREATE TABLE districts
(
    district_id      INT AUTO_INCREMENT PRIMARY KEY,
    district_name_uk VARCHAR(142) NOT NULL UNIQUE,
    district_name_ru VARCHAR(142) NOT NULL UNIQUE
);

-- Вставка унікальних районів з початкової таблиці
INSERT INTO districts (district_name_uk, district_name_ru)
SELECT DISTINCT area_name_uk, area_name_ru
FROM catalog_city;

-- Створюємо зв'язуючу таблицю між областями та районами
CREATE TABLE region_district
(
    region_district_id INT AUTO_INCREMENT PRIMARY KEY,
    region_id          INT,
    district_id        INT,
    FOREIGN KEY (region_id) REFERENCES regions (region_id),
    FOREIGN KEY (district_id) REFERENCES districts (district_id),
    UNIQUE (region_id, district_id)
);

-- Вставка унікальних комбінацій область-район з початкової таблиці
INSERT INTO region_district (region_id, district_id)
SELECT r.region_id, d.district_id
FROM catalog_city c
         JOIN regions r ON c.region_name_uk = r.region_name_uk AND c.region_name_ru = r.region_name_ru
         JOIN districts d ON c.area_name_uk = d.district_name_uk AND c.area_name_ru = d.district_name_ru
GROUP BY r.region_id, d.district_id;

-- Створюємо таблицю для назв міст
CREATE TABLE city_names
(
    city_name_id INT AUTO_INCREMENT PRIMARY KEY,
    name_uk      VARCHAR(142) NOT NULL UNIQUE,
    name_ru      VARCHAR(142) NOT NULL UNIQUE,
    slug         VARCHAR(71) NOT NULL UNIQUE
);

-- Вставка унікальних назв міст з початкової таблиці
INSERT INTO city_names (name_uk, name_ru, slug)
SELECT DISTINCT name_uk, name_ru, slug
FROM catalog_city;

-- Створюємо таблицю для міст,
-- Нова пошта має стрінгове, інші інтове... Робимо як бачимо. YAGNI
CREATE TABLE catalog_new
(
    id                  INT NOT NULL PRIMARY KEY,
    region_district_id  INT,
    city_name_id        INT,
    new_post_city_id    VARCHAR(77) NULL,
    justin_city_id      INT NULL,
    ukr_poshta_city_id  INT NULL,
    created_at          TIMESTAMP NOT NULL,
    updated_at          TIMESTAMP NOT NULL,
    FOREIGN KEY (region_district_id) REFERENCES region_district (region_district_id),
    FOREIGN KEY (city_name_id) REFERENCES city_names (city_name_id)
);

-- Вставка даних міст з початкової таблиці
INSERT INTO catalog_new (id, city_name_id, new_post_city_id, justin_city_id, ukr_poshta_city_id, region_district_id,
                         created_at, updated_at)
SELECT c.id,
       cn.city_name_id,
       c.new_post_city_id,
       c.justin_city_id,
       c.ukr_poshta_city_id,
       rd.region_district_id,
       c.created_at,
       c.updated_at
FROM catalog_city c
         JOIN city_names cn ON c.name_uk = cn.name_uk AND c.name_ru = cn.name_ru
         JOIN regions r ON c.region_name_uk = r.region_name_uk AND c.region_name_ru = r.region_name_ru
         JOIN districts d ON c.area_name_uk = d.district_name_uk AND c.area_name_ru = d.district_name_ru
         JOIN region_district rd ON r.region_id = rd.region_id AND d.district_id = rd.district_id;

-- Видаляємо початкову таблицю
DROP TABLE catalog_city;

-- Перейменовуємо нову таблицю
ALTER TABLE catalog_new RENAME TO catalog_city;
