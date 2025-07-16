# SecureApiClient

[![Latest Version on Packagist](https://img.shields.io/packagist/v/artapamudaid/secure-api-client.svg)](https://packagist.org/packages/artapamudaid/secure-api-client)
[![License](https://img.shields.io/github/license/artapamudaid/SecureApiClient.svg)](https://github.com/artapamudaid/SecureApiClient/blob/main/LICENSE)
[![Build Status](https://github.com/artapamudaid/SecureApiClient/actions/workflows/tests.yml/badge.svg)](https://github.com/artapamudaid/SecureApiClient/actions)

> Secure API Client with HMAC Signature, Nonce, and Timestamp – cocok untuk integrasi Laravel API yang aman.


**SecureApiClient** adalah library PHP sederhana untuk mengakses API yang dilindungi dengan sistem **API Key + API Secret + HMAC Signature**, lengkap dengan proteksi **nonce** dan **timestamp** untuk mencegah serangan replay.

Dirancang untuk digunakan dengan backend Laravel (misalnya Laravel Breeze + Middleware API Key).

---

## 🔐 Fitur

- Autentikasi via `X-API-KEY`, `X-API-SIGNATURE`, `X-NONCE`, `X-TIMESTAMP`
- Signature menggunakan `HMAC-SHA256`
- Mendukung `GET` dan `POST`
- Cocok untuk Laravel API Middleware berbasis API Key + Secret

---

## 🚀 Instalasi

### A. Jika dipublikasikan ke Packagist:

```bash
composer require artapamudaid/secure-api-client
