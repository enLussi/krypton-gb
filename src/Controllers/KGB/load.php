<?php

$this->addRoutes([
  "kgb"=> [
    "path"=> "/admin/kgb",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminKGBController"
  ],
  "mission"=> [
    "path"=> "/admin/kgb-mission",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminMissionController"
  ],
  "mission_country"=> [
    "path"=> "/admin/kgb-mission/country",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminFetchCountryController"
  ],
  "mission_involved"=> [
    "path"=> "/admin/kgb-mission/fetch",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminFetchInvolvedController"
  ],
  "mission_search"=> [
    "path"=> "/admin/kgb-mission/search",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminMissionSearchController"
  ],
  "new-mission"=> [
    "path"=> "/admin/kgb-mission/modify",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminMissionModifyController"
  ],
  "person"=> [
    "path"=> "/admin/kgb-involved",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminInvolvedController"
  ],
  "person_modify"=> [
    "path"=> "/admin/kgb-involved/modify",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminInvolvedModifyController"
  ],
  "person_search"=> [
    "path"=> "/admin/kgb-involved/search",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminInvolvedSearchController"
  ],
  "hideout"=> [
    "path"=> "/admin/kgb-hideout",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminHideoutController"
  ],
  "hideout_modify"=> [
    "path"=> "/admin/kgb-hideout/modify",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminHideoutModifyController"
  ],
  "hideout_search"=> [
    "path"=> "/admin/kgb-hideout/search",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminHideoutSearchController"
  ],
]);