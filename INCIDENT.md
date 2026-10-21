# PocketSQL Security Incident Response Playbook (`INCIDENT.md`)

This playbook defines emergency response steps for the PocketSQL portal (`pocketsql.prahlix.com`). Keep this document updated and execute immediately upon any suspected breach or vulnerability notification.

---

## 1. Emergency Contact & Roles

* **Primary Security Lead**: Prahlix Core Operations Team (`security@prahlix.com`)
* **General Incident Inbox**: `support@pocketsql.prahlix.com`
* **Escalation Notification**: Telegram/WhatsApp emergency internal broadcast channel.

---

## 2. Step 1: Immediate Session & Access Revocation

If an admin account is compromised or active unauthorized sessions are detected:

### A. Terminate All Active Sessions Immediately
Run via SSH/Terminal on the production server:
```bash
# Truncate active session records from database (forces all users/admins to re-authenticate)
php artisan session:table
php artisan tinker --execute="DB::table('sessions')->truncate();"
```

### B. Invalidate and Rotate Application Key
If `APP_KEY` was exposed or cookies compromised:
```bash
# Invalidate all encrypted cookies and existing session tokens
php artisan key:generate --force
php artisan config:clear
php artisan cache:clear
```

### C. Reset Admin Credentials
```bash
php artisan tinker --execute="\$admin = \App\Models\User::where('email', 'admin@pocketsql.prahlix.com')->first(); if (\$admin) { \$admin->password = bcrypt('NEW_SECURE_RANDOMLY_GENERATED_PASSWORD_16+'); \$admin->save(); }"
```

---

## 3. Step 2: Secret & Credential Rotation Matrix

If server credentials or keys are leaked:

| Secret | Rotation Command / Location | Impact |
| :--- | :--- | :--- |
| **`APP_KEY`** | `php artisan key:generate --force` | Logs out all users, invalidates all sessions and encrypted cookies |
| **Database Credentials** | Update `.env` `DB_PASSWORD` & reload web server | Disconnects any unauthorized direct database sessions |
| **Mail / SMTP Secrets** | Regenerate password in mail provider panel & update `.env` | Prevents unauthorized email relaying |
| **Google Play / Keystore** | Keep keystore file off web servers; rotate API service account keys | Protects official Android APK publishing integrity |

---

## 4. Step 3: Malicious Traffic & IP Containment

To immediately block an active attacking IP or subnet:

### A. Via PocketSQL Traffic Shield UI
1. Log in to `https://pocketsql.prahlix.com/admin/traffic`
2. Under **Quick IP Restriction**, enter the offending IP address.
3. Select duration (24h / 7d / Permanent) and click **Restrict IP**.

### B. Via Terminal / Tinker
```bash
php artisan tinker --execute="\App\Models\BlockedIp::blockIp('ATTACKER_IP', 'Emergency manual containment', 72);"
```

### C. Server Firewall (UFW / Nginx)
```bash
sudo ufw insert 1 deny from ATTACKER_IP to any
```

---

## 5. Step 4: Notification Obligations & Timelines

* **India DPDP Act (2023) / CERT-In**:
  * Mandatory cybersecurity incidents must be reported to **CERT-In** (Indian Computer Emergency Response Team) within **6 hours** of noticing the incident (email: `incident@cert-in.org.in`).
* **GDPR (EU Citizens)**:
  * If personal data of EU users is affected, report to the relevant Data Protection Authority (DPA) within **72 hours**.
* **User Notification**:
  * If user email or contact submissions were exposed, send a plain-language advisory detailing:
    1. What happened.
    2. What data was affected (passwords are bcrypt-hashed).
    3. What actions were taken to secure the system.
    4. Recommended steps (e.g. password resets).

---

## 6. Post-Incident Review
1. Export traffic logs for forensics: `php artisan tinker --execute="file_put_contents('storage/logs/breach_audit.json', json_encode(\App\Models\TrafficLog::where('created_at', '>=', now()->subDays(2))->get()));"`
2. Close exploited attack vector.
3. Restore clean backup if files were modified:
   ```bash
   # Restore sqlite database from backup
   cp storage/backups/pocketsql_clean.sqlite database/database.sqlite
   php artisan cache:clear
   ```
4. Document root cause and deploy preventive regression tests.
