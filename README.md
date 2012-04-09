#Ottawa's Splendid Splash Pad Locator

##Description
Ottawa's Splendid Splash Pad Locator is an open data application serving the Ottawa region with the location of every single public splash pad across the city.

**The locator holds features such as:**

- Secured Administration Panel
- Google Maps/Geolocations
- Splash Pad Rating System

##Copyright 
[BSD](https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt)

##Setup
1. Import the 'open-data-app.sql' file to your database. This SQL file contains all the location data such as the latitude, altitude, street address fields and a field for the name of the splash pad.

2. To use the latest and most updated version of the database, go to its [Ottawa Open Data Set](http://ottawa.ca/online_services/opendata/info/wading_pools_en.html) to get the KML file and import it using 'import-data.php'.

3. Create a database of users with fields for a username and a password to access the administration page.

4. Change the Google API Code in the JavaScript source code in the 'index.php' file to your own.

##Code Source
- [GitHub](https://github.com/pixelles/open-data-app)

##Demo
- [PHPFog](http://trishajessica.phpfogapp.com/)

##Project Brief
- [GitHub Page](http://pixelles.github.com/open-data-app/)