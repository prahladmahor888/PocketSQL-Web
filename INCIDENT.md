# PocketSQL Security Incident Response Playbook (`INCIDENT.md`)

This playbook outlines immediate containment, forensic, and recovery procedures for the PocketSQL application in the event of an unauthorized access, data breach, or security incident.

---

## 1. Immediate Threat Containment (P0 — Within 5 Minutes)

### Step 1: Revoke All Active Sessions Immediately
If an admin credential or session has been compromised, terminate all sessions across the platform:
```bash
# If using database sessions:
php artisan session:clear

# Or truncate sessions table directly in SQLite:
php artisan tinker --execute="DB::table('sessions')->truncate();"

# Force invalidate all encrypted cookies by rotating APP_KEY:
php artisan key:generate
```

### Step 2: Emergency Lockout of the Admin Portal
Temporarily block all administrative logins without taking down the public site:
```bash
# Set maintenance mode on admin prefix or restrict admin via Traffic Handler
php artisan down --secret="emergency-recovery-token"
```

### Step 3: Block Attacker IPs Immediately
```bash
# Blacklist offending IP via artisan tinker:
php artisan tinker --execute="App\Models\BlockedIp::blockIp('ATTACKER_IP', 'Manual Incident Containment', 720);"
```

---

## 2. Secret & Credential Rotation Checklist

Execute this checklist sequentially if any repository secret, `.env` file, or server access is suspected to be exposed:

1. **Application Encryption Key (`APP_KEY`)**:
   ```bash
   php artisan key:generate
   php artisan config:clear
   php artisan cache:clear
   ```
2. **Admin Account Password**:
   ```bash
   php artisan tinker --execute="App\Models\User::where('email', 'admin@pocketsql.app')->first()->update(['password' => bcrypt('NEW_HIGH_ENTROPY_PASSWORD')]);"
   ```
3. **Database Credentials**:
   * Rotate password in hosting control panel (Hostinger/cPanel/VPS).
   * Update `DB_PASSWORD` in `.env`.
4. **Payment Gateway Credentials (UPI / Razorpay)**:
   * Revoke existing `RAZORPAY_KEY_SECRET` in Razorpay Dashboard -> Settings -> API Keys.
   * Generate new key pair and update `.env`.
5. **Git Repository Sanitization**:
   * If any secret was committed to Git history, rotate the key in the upstream provider immediately. *Deleting the line in git does not revoke the compromised secret.*

---

## 3. Forensic Evidence Preservation

Before rebooting, restoring backups, or modifying files, preserve the evidence chain:
1. **Preserve Traffic & Security Logs**:
   * Export the SQLite database containing `traffic_logs`, `download_logs`, and `blocked_ips`:
   ```bash
   cp database/database.sqlite database/forensic_backup_$(date +%Y%m%d_%H%M%S).sqlite
   ```
2. **Export Web Server & System Logs**:
   * Archive `storage/logs/laravel.log`.
   * Archive Apache/Nginx access and error logs.

---

## 4. Breach Notification Obligations & Regulatory Reporting

* **CERT-In (India)**:
  * Under Indian Cybersecurity Regulations, cyber incidents (data breach, unauthorized system access, website defacement) must be reported to **CERT-In** (`incident@cert-in.org.in`) within **6 hours** of notice.
* **India Digital Personal Data Protection (DPDP) Act, 2023**:
  * Obligation to notify the Data Protection Board of India and affected data principals regarding personal data breaches.
* **GDPR (For European users if applicable)**:
  * Mandatory supervisory authority notification within **72 hours** under Article 33.

---

## 5. Security Contacts & Escalation

* **PocketSQL Engineering Lead**: `prahladmahor888@gmail.com`
* **Application Security / Support**: `support@pocketsql.app`
* **Emergency Hostinger / VPS Provider Support**: Hostinger Emergency Console
