Spotify Job Offers Analyzer
================================

Dear Reviewer,

The most important part of the application you can find in `/src` dir. I try to adopt Ports & Adapters/Onion Architecture here. I'm aware that Spotify Job Offers Analyzer is a very simple application and probably an app with such low complexity level do not need patterns like this. I assume that it could be a frame to build a more complex application and I would like to show a concept. `/src/JobOffersAnalyzer` should be treated as Business Logic layer - independent of a framework. `/src/App` should be treated as most outer layer where `/src/App/Command` is Primary Adapters layer and `/src/App/Repository` is Secondary Adapters layer.

Tests:
There are e2e, integration and unit tests implemented. You can find it in tests directory.
`tests/features` - e2e test written in behat
`tests/integration` - integration test (only one was required ;) ) written in PHPUnit
`tests/spec` - unit tests written in PHPSpec

For e2e test needs, I implemented a simple mock server. It is in `tests/feature/simple-mock-server` - is required for e2e tests correct work. When you use docker it runs automatically otherwise, you have to run it manually before launching e2e tests. Details, how to run it you can find in the instruction below.

To get and analyze all the job offers I decided not to scrap https://www.spotifyjobs.com/search-jobs/#location=sweden website directly.  
Instead of that, command grab job offers from https://www.spotifyjobs.com/wp-admin/admin-ajax.php which is used by spotifyjobs.com to load offers after clicking 'MORE JOBS' button. After that crawler gets a description for each offer one by one by loading a particular job offer website.   

I appreciate any feedback.

Regards 
Tomasz

============================

##System requirements
* PHP 7.1

###First run

Clone the app repository
```
git clone https://github.com/kaff/spot-scraper.git
```

##with Docker & docker-compose
(all command should be run in project root directory)

Run in bash
```
docker-compose build
docker-compose up -d
docker-compose exec php bash -c "composer install"
docker-compose exec php bash -c "bin/console JobOffersAnalyzer:spotify"             //command doesn't have any progressbar implemented, it can takes several seconds to get result, command generate report - check /var/report.csv

```

to run all test

```
docker-compose exec php bash -c "bin/behat && bin/phpspec run && bin/phpunit"
```

##without Docker 
Run in bash

```
composer install
bin/console JobOffersAnalyzer:spotify               //command generate report, check /var/report.csv
```

to run all test

```
php -S localhost:8000 tests/features/simple-mock-server/index.php                //run simple mock server for e2e tests needs
bin/behat && bin/phpspec run && bin/phpunit
```
