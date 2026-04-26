# Admin Quick Access (Manual DB Insert)

Insert this SQL in your database:

```sql
INSERT INTO users (name, email, email_verified_at, password, role, created_at, updated_at) VALUES 
('Admin', 'admin@hospital.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW());
```

**Password**: `password`

Then login at `/login`.

**Remove `/create-admin` route after use if not needed.**

**All pages functional!**


