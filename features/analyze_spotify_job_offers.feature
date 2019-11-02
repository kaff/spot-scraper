Feature:
  In order to analyze spotify job offers
  As a developer
  I want to have a command to trigger the analysis

  Scenario: Analyze spotify offers
    Given there are job offers on spotify website
    When I run analyzer by command "JobOffersAnalyzer:spotify"
    Then I have CVS report in "var/report.csv" with data:
    | url                                 | headline  | description                                       | for_experienced_professionals | required_years_of_experience |
    | http://localhost:8000?job=design-ux | Design UX | Expected 7+ years of relevant work experience ... | true                          | 7                            |
    | http://localhost:8000?job=developer | Developer | __DESCRIPTION_DEVELOPER__                         | true                          | n/a                          |
