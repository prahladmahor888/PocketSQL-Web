<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\CodeSnippet;
use App\Models\DonationMethod;
use App\Models\Faq;
use App\Models\Release;
use App\Models\Screenshot;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@pocketsql.app'],
            [
                'name' => 'PocketSQL Admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. App Settings
        AppSetting::updateOrCreate(
            ['id' => 1],
            [
                'current_version' => 'v1.0.5',
                'version_code' => 11,
                'apk_download_url' => '/download/apk',
                'playstore_url' => 'https://play.google.com/store/apps/details?id=app.pocketsql.database',
                'github_repo_url' => 'https://github.com/pocketsql/pocketsql',
                'documentation_url' => '/docs',
                'contact_email' => 'support@pocketsql.app',
                'release_notes' => 'PocketSQL v1.0.5 introduces native window functions, TLS 1.3 self-signed certificate generation on device, and 40+ MySQL system tables.',
                'api_server_active' => true,
            ]
        );

        // 3. Social Links
        $socialLinks = [
            [
                'platform' => 'github',
                'label' => 'GitHub',
                'url' => 'https://github.com/pocketsql/pocketsql',
                'icon_svg' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'platform' => 'discord',
                'label' => 'Discord',
                'url' => 'https://discord.gg/pocketsql',
                'icon_svg' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.894.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'platform' => 'telegram',
                'label' => 'Telegram',
                'url' => 'https://t.me/pocketsql_official',
                'icon_svg' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'platform' => 'twitter',
                'label' => 'X / Twitter',
                'url' => 'https://x.com/PocketSQLApp',
                'icon_svg' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(['platform' => $link['platform']], $link);
        }

        // 4. Screenshots
        $screenshots = [
            [
                'title' => 'PocketSQL Monitor & Terminal Console',
                'subtitle' => 'Connected to local engine in user space. Interactive command prompt with delimiter support and status indicators.',
                'image_path' => '/images/screenshots/terminal_welcome.png',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'API Keys & Background Server',
                'subtitle' => 'Foreground Android daemon listening on port 8080 with granular API token generation and client guides.',
                'image_path' => '/images/screenshots/api_keys_server.png',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Multi-Row Batch Insert & Query Timing',
                'subtitle' => 'Direct relational execution showing multi-row inserts into USERS table with microsecond execution feedback.',
                'image_path' => '/images/screenshots/terminal_select.png',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Built-in SQL Templates Library',
                'subtitle' => 'Instant access to categorized templates for Basic Queries, Joins, Alter Table, and Admin routines with 1-tap paste.',
                'image_path' => '/images/screenshots/sql_templates.png',
                'sort_order' => 4,
                'is_featured' => true,
            ],
        ];

        // Clear existing to match current set
        Screenshot::query()->delete();
        foreach ($screenshots as $item) {
            Screenshot::create($item);
        }

        // 5. Code Snippets
        $snippets = [
            [
                'language' => 'python',
                'title' => 'Python (requests)',
                'sort_order' => 1,
                'code_content' => <<<'CODE'
import requests

url = "http://192.168.1.100:8080/api/query"
headers = {
    "Authorization": "Bearer YOUR_POCKETSQL_API_KEY",
    "Content-Type": "application/json"
}
payload = {
    "database": "ecommerce",
    "sql": "SELECT id, product_name, price, stock FROM products WHERE stock > 0 ORDER BY price DESC LIMIT 5;"
}

response = requests.post(url, json=payload, headers=headers)
data = response.json()

if data.get("success"):
    print(f"Executed in {data['executionTimeMs']}ms")
    for row in data["rows"]:
        print(f"[{row['id']}] {row['product_name']} - ${row['price']}")
else:
    print("Error:", data.get("error"))
CODE
            ],
            [
                'language' => 'javascript',
                'title' => 'JavaScript (Node / Fetch)',
                'sort_order' => 2,
                'code_content' => <<<'CODE'
const response = await fetch("http://192.168.1.100:8080/api/query", {
  method: "POST",
  headers: {
    "Authorization": "Bearer YOUR_POCKETSQL_API_KEY",
    "Content-Type": "application/json"
  },
  body: JSON.stringify({
    database: "ecommerce",
    sql: "SELECT id, product_name, price FROM products LIMIT 5;"
  })
});

const result = await response.json();
if (result.success) {
  console.log(`Query took ${result.executionTimeMs}ms:`);
  console.table(result.rows);
} else {
  console.error("SQL Error:", result.error);
}
CODE
            ],
            [
                'language' => 'java',
                'title' => 'Java (HttpClient)',
                'sort_order' => 3,
                'code_content' => <<<'CODE'
import java.net.URI;
import java.net.http.*;

HttpClient client = HttpClient.newHttpClient();
String payload = """
    {
      "database": "ecommerce",
      "sql": "SELECT id, product_name, price FROM products LIMIT 5;"
    }
    """;

HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("http://192.168.1.100:8080/api/query"))
    .header("Authorization", "Bearer YOUR_POCKETSQL_API_KEY")
    .header("Content-Type", "application/json")
    .POST(HttpRequest.BodyPublishers.ofString(payload))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println("Status: " + response.statusCode());
System.out.println("Result: " + response.body());
CODE
            ],
            [
                'language' => 'php',
                'title' => 'PHP (cURL)',
                'sort_order' => 4,
                'code_content' => <<<'CODE'
<?php
$ch = curl_init('http://192.168.1.100:8080/api/query');
$payload = json_encode([
    'database' => 'ecommerce',
    'sql' => 'SELECT id, product_name, price FROM products LIMIT 5;'
]);

curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer YOUR_POCKETSQL_API_KEY',
        'Content-Type: application/json'
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
print_r($result);
CODE
            ],
            [
                'language' => 'bash',
                'title' => 'cURL (Bash)',
                'sort_order' => 5,
                'code_content' => <<<'CODE'
curl -X POST "http://192.168.1.100:8080/api/query" \
  -H "Authorization: Bearer YOUR_POCKETSQL_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "database": "ecommerce",
    "sql": "SELECT id, product_name, price FROM products LIMIT 5;"
  }'
CODE
            ],
        ];

        foreach ($snippets as $snippet) {
            CodeSnippet::updateOrCreate(['language' => $snippet['language']], $snippet);
        }

        // 6. FAQs
        $faqs = [
            [
                'category' => 'General',
                'question' => 'Does PocketSQL require root access on Android?',
                'answer' => 'No! PocketSQL runs 100% in user space without requiring root permissions, Busybox, or Magisk. It runs smoothly on any Android device running Android 10 (API 29) through Android 15 (API 36).',
                'sort_order' => 1,
            ],
            [
                'category' => 'General',
                'question' => 'Is PocketSQL completely free and open-source for commercial use?',
                'answer' => 'Yes. PocketSQL is released under the permissive MIT License. You are free to use it for personal projects, academic research, enterprise prototypes, or embedded IoT test fixtures without licensing fees or royalties.',
                'sort_order' => 2,
            ],
            [
                'category' => 'API & Networking',
                'question' => 'How do I connect from my laptop or PC to PocketSQL running on my phone?',
                'answer' => 'Ensure your phone and laptop are connected to the same Wi-Fi network (or phone hotspot). Open PocketSQL on your phone, start the Background API Server, and note the IP displayed on the screen (e.g. 192.168.1.100:8080). You can now send HTTP POST requests to http://<phone-ip>:8080/api/query using your bearer API key.',
                'sort_order' => 3,
            ],
            [
                'category' => 'API & Networking',
                'question' => 'What happens if port 8080 is already occupied on the device?',
                'answer' => 'PocketSQL features automatic intelligent port scanning. If port 8080 is taken by another app or system service, it will scan incrementally and bind to the first available port up to 8099, clearly displaying the active port in both the app interface and the foreground notification.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Battery & Performance',
                'question' => 'Does keeping the background API server running drain battery life?',
                'answer' => 'PocketSQL is engineered for ultra-low power consumption. When no queries are being executed, worker threads enter an idle wait state with near-zero CPU cycles. It operates as an official Android Foreground Service with standard battery optimization compliance.',
                'sort_order' => 5,
            ],
            [
                'category' => 'Battery & Performance',
                'question' => 'What is the maximum database size supported by PocketSQL?',
                'answer' => 'Database capacity is limited only by your Android device available storage. PocketSQL employs a high-performance indexed B-Tree page engine and memory-mapped virtual disk storage capable of effortlessly handling multi-gigabyte databases.',
                'sort_order' => 6,
            ],
            [
                'category' => 'Data Security & Privacy',
                'question' => 'Is any of my database data or SQL queries sent to third-party cloud servers?',
                'answer' => 'Never. PocketSQL is strictly 100% offline-first. There are zero remote cloud telemetry, tracking, or analytics SDKs embedded in the app. Your tables, databases, credentials, and query logs remain exclusively on your device hardware.',
                'sort_order' => 7,
            ],
            [
                'category' => 'Data Security & Privacy',
                'question' => 'How are API keys and database credentials secured on the phone?',
                'answer' => 'API keys and sensitive configurations are encrypted using AES-256 GCM backed by the Android Keystore system (EncryptedSharedPreferences). Database files can also be exported with SQLCipher 256-bit AES encryption.',
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }

        // 7. Donation Methods
        $donations = [
            [
                'method_name' => 'UPI (India)',
                'account_identifier' => 'pocketsql@upi',
                'qr_image_path' => '/images/upi_qr.svg',
                'payment_url' => 'upi://pay?pa=pocketsql@upi&pn=PocketSQL%20Project&cu=INR',
                'instructions' => 'Scan the UPI QR code or copy the UPI ID using Google Pay, PhonePe, Paytm, or BHIM. Zero payment gateway fees, instant support.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'method_name' => 'Buy Me A Coffee',
                'account_identifier' => 'buymeacoffee.com/pocketsql',
                'qr_image_path' => null,
                'payment_url' => 'https://buymeacoffee.com/pocketsql',
                'instructions' => 'Fast, friendly one-time support via credit card, Apple Pay, or Google Pay for supporters worldwide.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'method_name' => 'PayPal',
                'account_identifier' => 'paypal.me/pocketsql',
                'qr_image_path' => null,
                'payment_url' => 'https://paypal.me/pocketsql',
                'instructions' => 'International direct donations through PayPal in USD, EUR, GBP, and more.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'method_name' => 'GitHub Sponsors',
                'account_identifier' => 'github.com/sponsors/pocketsql',
                'qr_image_path' => null,
                'payment_url' => 'https://github.com/sponsors/pocketsql',
                'instructions' => 'Become a monthly sponsor or provide a one-time grant directly through your GitHub account with zero platform fees.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'method_name' => 'Crypto (USDT / BTC)',
                'account_identifier' => 'USDT (TRC-20): TQzPocketSQL3981Gj90124KLa\nBTC: bc1qpocketsql89124098124jklm',
                'qr_image_path' => null,
                'payment_url' => null,
                'instructions' => 'For decentralized and privacy-minded sponsors. Network: USDT on Tron (TRC-20) or Native Bitcoin (SegWit).',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($donations as $donation) {
            DonationMethod::updateOrCreate(['method_name' => $donation['method_name']], $donation);
        }

        // 8. Releases
        $releases = [
            [
                'version' => 'v1.0.5',
                'version_code' => 11,
                'release_date' => 'October 18, 2026',
                'apk_size' => '12.4 MB',
                'sha256_hash' => '9b8c73e4a2d109ef78b23c914e67f0821bcfa239d87130284ab9102ef108ca73',
                'changelog' => "• Added native analytical Window Functions (PERCENT_RANK, NTILE, DENSE_RANK, ROW_NUMBER).\n• Integrated on-device TLS 1.3 self-signed certificate generation with automated SHA-256 fingerprint display.\n• Added 40+ system tables emulating mysql, information_schema, performance_schema, and sys.\n• Implemented automatic port-hopping fallback from port 8080 up to 8099.\n• Added instant SQL export to Excel XLSX format and compressed ZIP archives.\n• Updated Android 15 (API 36) foreground service permission policies and SDK target.",
                'download_url' => '/download/apk',
                'is_latest' => true,
            ],
            [
                'version' => 'v1.0.4',
                'version_code' => 10,
                'release_date' => 'August 12, 2026',
                'apk_size' => '11.9 MB',
                'sha256_hash' => '3f91bc782d41a0e88941cb91207eef3459012aab74619cd43e7b1456a0094182',
                'changelog' => "• Added Bearer token management with granular per-database read/write scoping.\n• Fixed foreign key ON DELETE CASCADE edge cases with multi-level nested tables.\n• Enhanced SQL keyword autocomplete speed in terminal by 45%.\n• Added support for DELIMITER // custom batch delimiters in console.",
                'download_url' => '/download/apk',
                'is_latest' => false,
            ],
            [
                'version' => 'v1.0.3',
                'version_code' => 9,
                'release_date' => 'June 02, 2026',
                'apk_size' => '11.2 MB',
                'sha256_hash' => 'e41a980bc7123910ef87a4192b01289cfba20941cba87410294eef108ca91203',
                'changelog' => "• Initial stable release of embedded HTTP REST API server.\n• Added support for SQLite and encrypted SQLCipher database import.\n• Implemented JetBrains Mono terminal interface with query history retention.",
                'download_url' => '/download/apk',
                'is_latest' => false,
            ],
        ];

        foreach ($releases as $release) {
            Release::updateOrCreate(['version' => $release['version']], $release);
        }
    }
}
