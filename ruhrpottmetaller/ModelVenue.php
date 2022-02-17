<?php

namespace ruhrpottmetaller;

class ModelVenue
{
    private ?\mysqli $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getVenues()
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, city_id AS stadt_id, url FROM venue ORDER BY name');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getVenuesByCity(string $city_id)
    {
        $mysqli = $this->mysqli;
        if ($city_id == '') {
            $stmt = $mysqli->prepare('
                SELECT venue.id, venue.name, city.name AS city_name, venue.stadt_id, venue.url
                FROM venue
                JOIN city ON venue.city_id = city.id
                ORDER BY city.name, venue.name
            ');
        } else {
            $stmt = $mysqli->prepare('
                SELECT venue.id, venue.name, city.name AS city_name, city_id, venue.url 
                FROM venue
                JOIN city ON location.stadt_id = stadt.id
                WHERE city_id=?
                ORDER BY venue.name
            ');
            $stmt->bind_param('i', $city_id);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getVenueById(int $id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, city_id, url FROM venue WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function setVenue(string $name, int $city_id, string $url): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO venue SET name=?, city_id=?, url=?');
        $stmt->bind_param('sis', $name, $city_id, $url);
        $stmt->execute();
        $result = $this->mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    public function updateVenue(int $id, string $name, string $url): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE venue SET name=?, url=? WHERE id=?');
        $stmt->bind_param('ssi', $name, $url, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
