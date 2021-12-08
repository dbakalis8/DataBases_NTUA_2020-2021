CREATE INDEX popular_places ON visit(place_id);
CREATE INDEX most_used_services ON service_charge(description_of_charge);
CREATE INDEX popular_services ON enjoy_services(nfc_id);