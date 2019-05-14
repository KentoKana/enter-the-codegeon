<?php
  $variables = [
      'GOOGLE_CLIENT_ID' => '521573106862-n4viuuv5b48h6j9mv48tuk2l6aded2af.apps.googleusercontent.com',
      'GOOGLE_SECRET' => 'CPtlZyJ4x1DkGCoeH0rgO6CJ',
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
