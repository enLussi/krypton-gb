<?php

$this->addRoutes([
  "kgb"=> [
    "path"=> "/admin/kgb",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminKGBController"
  ],
  "mission"=> [
    "path"=> "/admin/kgb-new-mission",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminMissionController"
  ],
  "mission_country"=> [
    "path"=> "/admin/kgb-new-mission/country",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminFetchCountryController"
  ],
  "mission_involved"=> [
    "path"=> "/admin/kgb-new-mission/fetch",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminFetchInvolvedController"
  ],
  "new-mission"=> [
    "path"=> "/admin/kgb-new-mission/send-mission",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminSendNewMissionController"
  ],
  "person"=> [
    "path"=> "/admin/kgb-new-involved",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminInvolvedController"
  ],
  "hideout"=> [
    "path"=> "/admin/kgb-new-hideout",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminHideoutController"
  ],
]);