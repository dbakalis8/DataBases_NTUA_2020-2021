CREATE VIEW customer_info AS
SELECT
  DISTINCT c.first_name,
  c.last_name,
  c.birthdate,
  c.nfc_id,
  c.number_of_id_doc,
  c.type_of_id_doc,
  c.authority_of_id_doc,
  p.phone_number,
  e.email
FROM
  customer c
  LEFT JOIN customer_phone p on c.nfc_id = p.nfc_id
  LEFT JOIN customer_email e on p.nfc_id = e.nfc_id