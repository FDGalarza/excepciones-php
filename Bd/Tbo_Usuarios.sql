-- Table: usuarios

-- DROP TABLE usuarios;

CREATE TABLE usuarios
(
  correo_electronico character varying(20),
  nombreusuario character varying(20),
  nombre_completo character varying(50),
  password character varying(500),
  estado character varying(30),
  rol character varying(10)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE usuarios
  OWNER TO postgres;
