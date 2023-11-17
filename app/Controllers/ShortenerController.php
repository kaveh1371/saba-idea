<?php

namespace SabaIdea\Controllers;

use SabaIdea\Services\ShortenerService;

class ShortenerController
{
	public function index()
	{
		// die(var_dump($_ENV['MYSQL_ROOT_HOST']));
		$URLs = (new ShortenerService())->getShortURLs();
		return response()->json($URLs);
	}

	public function create()
	{
		$shortURL = (new ShortenerService())->generateShortURL($_POST['long_url']);
		return response()->json(["URL" => "http://www.example.com/$shortURL"]);
	}

	public function update($id)
	{
		(new ShortenerService())->updateShortURL($id, $_POST['long_url'], $_POST['short_url']);
		return response()->json(["message" => "success"]);
	}

	public function destroy($id)
	{
		(new ShortenerService())->removeShortURL($id);
		return response()->json(["message" => "success"]);
	}

	public function notFound()
	{
		die('not found');
	}
}
