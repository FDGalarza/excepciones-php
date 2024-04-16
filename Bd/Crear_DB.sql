-- Database: asesores

-- DROP DATABASE asesores;

CREATE DATABASE asesores
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'Spanish_Spain.1252'
       LC_CTYPE = 'Spanish_Spain.1252'
       CONNECTION LIMIT = 1;
GRANT ALL ON DATABASE asesores TO postgres;
GRANT ALL ON DATABASE asesores TO public;

