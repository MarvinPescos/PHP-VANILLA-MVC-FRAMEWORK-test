<?php
// app/Core/Auth.php

namespace App\Core;

use App\Models\User;
use App\Core\Model;

abstract class Auth
{
  protected static $user = null;

  public static function check()
  {
    return isset($_SESSION['user']);
  }

  public static function user()
  {
    // Check if user data is already loaded or if the session exists
    if (self::$user === null && self::check()) {
      $sessionUser = $_SESSION['user'];
      // Ensure session data is an array and has an 'id' key
      if (is_array($sessionUser) && isset($sessionUser['id'])) {
        // Fetch user details using the ID from the session array
        self::$user = User::find($sessionUser['id']);
      } elseif (is_object($sessionUser) && isset($sessionUser->id)) {
        // Fetch user details using the ID from the session object
        self::$user = User::find($sessionUser->id);
      }
      // If session data is invalid or find fails, self::$user remains null
    }
    return self::$user;
  }

// public static function getByUserId($user = null)
//   {
//     $user = $user ?? static::user();
//     if (!$user)
//       return null;

//     return is_array($user)
//       ? ($user['id'] ?? null)
//       : ($user->id ?? null);
//   }

  public static function login($user)
  {
    if (!$user) {
      throw new \Exception('User not found or invalid');
  }

  // Clear the old session to prevent user data mix-up
  session_unset();  // Remove all session variables
  session_destroy(); // Destroy the old session
  session_start();  // Start a new session

  // Store the new logged-in user
  $_SESSION['user'] = $user;

  // Regenerate session ID to prevent session fixation attacks
  session_regenerate_id(true);
  }

  public static function logout()
  {
    session_destroy(); // Destroy the session
    session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks
  }
}
