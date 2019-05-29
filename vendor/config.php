<?php
  $variables = [
      'GOOGLE_CLIENT_ID' => '281449210433-cve7aj83778tpngaqbba84agorpoobsk.apps.googleusercontent.com',
      'GOOGLE_SECRET' => 'C7V8djklYl2Pf5BMx-aDDV_S',
      'MONGO_URI' => 'mongodb+srv://mok0ng:LSjjYqx0QnyegUYv@codegeon-cluster-vtqvv.mongodb.net/test?retryWrites=true',
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }

  if(!function_exists('env')) {
      function env($key, $default = null)
      {
          $value = getenv($key);
          if ($value === false) {
              return $default;
          }
          return $value;
      }
  }
