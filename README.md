# vuln-fixture-php

PHP vulnerable fixture for IVAS QA.

> ⚠️ 의도적으로 취약하게 작성된 테스트 픽스처입니다. 절대 운영 환경에 사용하지 마세요.
> 모든 시크릿/키는 형식만 진짜 같은 **가짜 값**입니다.

## 의도된 취약점 (6종 — node 픽스처보다 적게 구성)

### PHP (`index.php`, `src/utils.php`)
- 모든 라우트는 **명명된 핸들러 함수**(`handle_user`, `handle_ping` 등)로 분리 — IVAS 함수 매칭용
- `src/utils.php`의 `extract_archive`, `insecure_hash`는 `/extract`, `/utils-hash` 라우트에서 **호출 연결**
- SQL Injection — 문자열 연결 쿼리 조립
- Command Injection — `system()` / `shell_exec()`
- Path Traversal / LFI — 검증 없는 `file_get_contents()`
- 객체 역직렬화 — `unserialize($_GET[...])`
- SSRF — `file_get_contents($user_url)`
- 약한 해시 — `md5()`
- (그 외) 하드코딩 시크릿, `display_errors` 노출

### 의존성
- `composer.json` — 알려진 CVE 보유 PHP 패키지 구버전 (monolog, guzzle, twig 등)

### Docker
- `Dockerfile` — root 실행, `latest` 태그, ENV 시크릿 노출
