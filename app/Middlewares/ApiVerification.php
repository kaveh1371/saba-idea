<?php

namespace SabaIdea\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ApiVerification implements IMiddleware
{
	public function handle(Request $request): void
	{
		if (!isset($_SERVER['HTTP_PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'No authentication credentials provided';
			exit;
		} elseif ($_SERVER['HTTP_PHP_AUTH_USER'] !== 'username' || $_SERVER['HTTP_PHP_AUTH_PW'] !== 'password') {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'Invalid username or password';
			exit;
		}
	}
}
