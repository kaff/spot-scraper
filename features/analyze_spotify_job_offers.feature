Feature:
  In order to analyze spotify job offers
  As a developer
  I want to have a command to trigger the analysis

  Scenario: Analyze spotify offers
    Given there are job offers on spotify website
    When I run analyzer by command "JobOffersAnalyzer:spotify"
    Then I have CVS report in "var/report.csv" with data:
    | URL     | Headline    | Description     | For experienced professionals | Required years on experience |
    | __URL__ | __HEDLINE__ | __DESCRIPTION__ | true                          | 6                            |
