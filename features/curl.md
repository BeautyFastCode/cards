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
