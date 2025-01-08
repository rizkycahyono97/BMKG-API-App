<?php


Router::get('','StaticPagesController@serveLogin');
Router::get('login','StaticPagesController@serveLogin');
Router::get('home','StaticPagesController@serveHome');

// Weather
Router::get('/dashboard', 'WeatherController@getWeather');
Router::get('/get-cities', 'CityController@getCities');
Router::get('/api/cities', 'CityController@getCities');
Router::get('/api/subdistricts', 'CityController@getSubdistricts');

// Halaman pencarian cuaca
Router::get('/search', 'CitiesController@index');
// Proses pencarian cuaca
Router::post('/search', 'CitiesController@searchWeather');


?>