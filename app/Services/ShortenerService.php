<?php

namespace SabaIdea\Services;

class ShortenerService
{
    public function getShortURLs()
    {
        $DBService = new DatabaseService();
        $sql = "SELECT * FROM urls";
        return $DBService->prepare($sql)
            ->execute()
            ->fetch();
    }

    public function generateShortURL($longURL)
    {
        $DBService = new DatabaseService();
        $DBService->beginTransaction();

        try {
            // Generate a random short URL
            $shortURL = substr(md5(microtime()), 0, 6);

            // Check if the short URL already exists
            $sql = sprintf("SELECT * FROM urls WHERE short_url = \"%s\"", $shortURL);
            $queryResult = $DBService->prepare($sql)
                ->execute()
                ->fetch();

            if (count($queryResult) > 0) {
                // If the short URL already exists, generate a new one
                $DBService->rollBack();
                return $this->generateShortURL($longURL);
            } else {
                // Insert the long URL and short URL into the database
                $sql = sprintf("INSERT INTO urls (long_url, short_url) VALUES (\"%s\", \"%s\")", $longURL, $shortURL);
                $DBService->prepare($sql);
                $DBService = $DBService->execute();

                $DBService = $DBService->commit(); // Commit the transaction
                return $shortURL;
            }
        } catch (\Exception $e) {
            $DBService->rollBack(); // Rollback the transaction if an error occurs
            throw $e;
        }
    }

    public function updateShortURL($id, $longURL = null, $shortURL = null)
    {
        $sql = sprintf("SELECT * FROM urls WHERE id = %d", $id);
        $DBService = new DatabaseService();
        $oldURL = $DBService->prepare($sql)
            ->execute()
            ->fetch();
        if (!$longURL) {
            $longURL = $oldURL[0]["long_url"];
        }
        if (!$shortURL) {
            $shortURL = $oldURL[0]["short_url"];
        }
        $sql = sprintf("UPDATE urls SET long_url = \"%s\", short_url = \"%s\" WHERE id = %d", $longURL, $shortURL, $id);
        $DBService->prepare($sql)
            ->execute();
    }

    public function removeShortURL($id)
    {
        $sql = sprintf("DELETE FROM urls WHERE id = %d", $id);
        (new DatabaseService())->prepare($sql)
            ->execute();
    }
}
