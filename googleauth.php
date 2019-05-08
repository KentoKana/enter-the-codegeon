<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Grant\RefreshToken;

// check if user is logged in
if(isset($_SESSION['userid']))
{
  header('Location: profile.php');
}
else
{
  // connect to mongoDB
  $client = new MongoDB\Client(env('MONGO_URI'));

  // access the collection
  $collection = $client->codegen->users;

  $provider = new Google([
      'clientId'     => env('GOOGLE_CLIENT_ID'),
      'clientSecret' => env('GOOGLE_SECRET'),
      'redirectUri'  => 'http://localhost/enter-the-codegeon/googleauth.php'
  ]);

  if (!empty($_GET['error'])) {

      // Got an error, probably user denied access
      exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));

  } elseif (empty($_GET['code'])) {

      // If we don't have an authorization code then get one
      $authUrl = $provider->getAuthorizationUrl();
      $_SESSION['oauth2state'] = $provider->getState();
      header('Location: ' . $authUrl);
      exit;

  } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

      // State is invalid, possible CSRF attack in progress
      unset($_SESSION['oauth2state']);
      exit('Invalid state');

  } else {
    // store the refresh token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $user = $provider->getResourceOwner($token);

    if($user)
    {
      // check if user already exists
      $user_registered = $collection->findOne(['googleId' => $user->getId()]);
      if($user_registered)
      {
        // insert the user id
        $_SESSION['userid'] = (string)$user_registered->_id;
      }
      else
      {
        // add the record to database
        $insertRecord = $collection->insertOne([
          'googleId' => $user->getId(),
          'username' => $user->getEmail(),
          'email' => $user->getEmail(),
          'firstName' => $user->getFirstName(),
          'lastName' => $user->getLastName(),
        ]);

        // check if successful
        if($insertRecord->getInsertedCount() == 1)
        {
          // insert the userid into session
          $_SESSION['userid'] = $insertRecord->getInsertedId();
        }
      }
      // redirect the user
      header('Location: profile.php');
    }
  }
}
