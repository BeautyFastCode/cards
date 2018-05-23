# Users
 
- Visitor
- Customer
- Administrator
- Developer

---

# Tags

- @ui @email

- @ui
- @email
- @api

- @homepage
- @customer-registration
- @customer-login
- @customer-logout
- @learning

- @suite
- @deck
- @card

- @edge_case

---

# `curl` snippets for manual testing

```
curl -X POST \
  http://127.0.0.1:8000/api/suites \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -d '{
        "name": "",
      }' >> test.html
```

---

# Print all available step definitions

```
vendor/bin/behat -dl > behat-dl.txt
```

---
