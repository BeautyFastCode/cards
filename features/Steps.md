# Print all available step definitions

```
vendor/bin/behat -dl > behat-dl.txt
```

---

```
default | When a demo scenario sends a request to :path
default | Then the response should be received
default | Given /^(?:|I )am on (?:|the )homepage$/
default | When /^(?:|I )go to (?:|the )homepage$/
default | Given /^(?:|I )am on "(?P<page>[^"]+)"$/
default | When /^(?:|I )go to "(?P<page>[^"]+)"$/
default | When /^(?:|I )reload the page$/
default | When /^(?:|I )move backward one page$/
default | When /^(?:|I )move forward one page$/
default | When /^(?:|I )press "(?P<button>(?:[^"]|\\")*)"$/
default | When /^(?:|I )follow "(?P<link>(?:[^"]|\\")*)"$/
default | When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with "(?P<value>(?:[^"]|\\")*)"$/
default | When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with:$/
default | When /^(?:|I )fill in "(?P<value>(?:[^"]|\\")*)" for "(?P<field>(?:[^"]|\\")*)"$/
default | When /^(?:|I )fill in the following:$/
default | When /^(?:|I )select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
default | When /^(?:|I )additionally select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
default | When /^(?:|I )check "(?P<option>(?:[^"]|\\")*)"$/
default | When /^(?:|I )uncheck "(?P<option>(?:[^"]|\\")*)"$/
default | When /^(?:|I )attach the file "(?P<path>[^"]*)" to "(?P<field>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should be on "(?P<page>[^"]+)"$/
default | Then /^(?:|I )should be on (?:|the )homepage$/
default | Then /^the (?i)url(?-i) should match (?P<pattern>"(?:[^"]|\\")*")$/
default | Then /^the response status code should be (?P<code>\d+)$/
default | Then /^the response status code should not be (?P<code>\d+)$/
default | Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should see text matching (?P<pattern>"(?:[^"]|\\")*")$/
default | Then /^(?:|I )should not see text matching (?P<pattern>"(?:[^"]|\\")*")$/
default | Then /^the response should contain "(?P<text>(?:[^"]|\\")*)"$/
default | Then /^the response should not contain "(?P<text>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
default | Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
default | Then /^the "(?P<element>[^"]*)" element should contain "(?P<value>(?:[^"]|\\")*)"$/
default | Then /^the "(?P<element>[^"]*)" element should not contain "(?P<value>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should see an? "(?P<element>[^"]*)" element$/
default | Then /^(?:|I )should not see an? "(?P<element>[^"]*)" element$/
default | Then /^the "(?P<field>(?:[^"]|\\")*)" field should contain "(?P<value>(?:[^"]|\\")*)"$/
default | Then /^the "(?P<field>(?:[^"]|\\")*)" field should not contain "(?P<value>(?:[^"]|\\")*)"$/
default | Then /^(?:|I )should see (?P<num>\d+) "(?P<element>[^"]*)" elements?$/
default | Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should be checked$/
default | Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox is checked$/
default | Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" (?:is|should be) checked$/
default | Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should (?:be unchecked|not be checked)$/
default | Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox is (?:unchecked|not checked)$/
default | Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" should (?:be unchecked|not be checked)$/
default | Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" is (?:unchecked|not checked)$/
default | Then /^print current URL$/
default | Then /^print last response$/
default | Then /^show last response$/
default | When (I )start timing now
default | When I set basic authentication with :user and :password
default | Given (I )am on url composed by:
default | When (I )click on the :index :element element
default | When (I )follow the :index :link link
default | When (I )press the :index :button button
default | When (I )fill in :field with the current date
default | When (I )fill in :field with the current date and modifier :modifier
default | When (I )hover :element
default | When (I )save the value of :field in the :parameter parameter
default | Then (I )wait :count second(s) until I see :text
default | Then (I )should not see :text within :count second(s)
default | Then (I )wait until I see :text
default | Then (I )wait :count second(s) until I see :text in the :element element
default | Then (I )wait :count second(s)
default | Then (I )wait until I see :text in the :element element
default | Then (I )wait for :element element
default | Then (I )wait :count second(s) for :element element
default | Then /^(?:|I )should see (?P<count>\d+) "(?P<element>[^"]*)" in the (?P<index>\d+)(?:st|nd|rd|th) "(?P<parent>[^"]*)"$/
default | Then (I )should see less than :count :element in the :index :parent
default | Then (I )should see more than :count :element in the :index :parent
default | Then the element :element should be enabled
default | Then the element :element should be disabled
default | Then the :select select box should contain :option
default | Then the :select select box should not contain :option
default | Then the :element element should be visible
default | Then the :element element should not be visible
default | When (I )switch to iframe :name
default | When (I )switch to frame :name
default | When (I )switch to main frame
default | Then (the )total elapsed time should be :comparison than :expected seconds
default | Then (the )total elapsed time should be :comparison to :expected seconds
default | Then the response should be in XML
default | Then the response should not be in XML
default | Then the XML element :element should exist(s)
default | Then the XML element :element should not exist(s)
default | Then the XML element :element should be equal to :text
default | Then the XML element :element should not be equal to :text
default | Then the XML attribute :attribute on element :element should exist(s)
default | Then the XML attribute :attribute on element :element should not exist(s)
default | Then the XML attribute :attribute on element :element should be equal to :text
default | Then the XML attribute :attribute on element :element should not be equal to :text
default | Then the XML element :element should have :count element(s)
default | Then the XML element :element should contain :text
default | Then the XML element :element should not contain :text
default | Then the XML should use the namespace :namespace
default | Then the XML should not use the namespace :namespace
default | Then print last XML response
default | Then the XML feed should be valid according to its DTD
default | Then the XML feed should be valid according to the XSD :filename
default | Then the XML feed should be valid according to this XSD:
default | Then the XML feed should be valid according to the relax NG schema :filename
default | Then the XML feed should be valid according to this relax NG schema:
default | Then the atom feed should be valid
default | Then the RSS2 feed should be valid
```
