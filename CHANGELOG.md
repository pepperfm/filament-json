# Changelog

All notable changes to `filament-json` will be documented in this file.

## 2.0 - 2025-03-22

### Added feature to display nested data with maxDepth = 2

This json content

```json
{
  "ip": "127.0.0.1",
  "subdata": {
    "1": 321,
    "wow": "123"
  },
  "user_agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 YaBrowser/25.2.0.0 Safari/537.36",
  "fingerprint": null,
  "subDataArray": [
    1,
    2,
    "test"
  ]
}

```
#### should looks like:
![image](https://github.com/user-attachments/assets/ede77bb3-bea9-4e98-ad40-1996e2ef2122)

This json content with this nesting level

```json
{
  "more_nested_array": [
    "scroll_checking",
    "scroll_checking2",
    {
      "scroll_checking_2_1": 1,
      "scroll_checking_2_2": {
        "data": {
          "some_bool_key": true
        }
      }
    }
  ],
  "arrayWithRandomSubData": [
    1,
    "2",
    {
      "1": 1,
      "2": "qweqwe",
      "response": {
        "data": {
          "some_bool_key": true
        }
      }
    }
  ]
}

```
should looks like:

![image](https://github.com/user-attachments/assets/e5def208-8432-4498-8e22-fca9d700c487)

## 1.0.0 - 202X-XX-XX

- initial release
