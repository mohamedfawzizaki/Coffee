Here’s a clear, production-ready prompt that captures your exact logic:

---

**Prompt:**

I am building a Laravel API for a mobile app and want to implement a **referral system with single-use referral codes**.

### Core Business Logic:

1. **Referral Code Lifecycle:**

   * The `referral_code` in the `customers` table should be **NULL by default**.
   * A referral code is generated **only when the customer calls the "Generate Referral Link" endpoint**.

2. **Generate Referral Link Endpoint:**

   * When a customer requests a referral link:

     * If `referral_code` is `NULL`:

       * Generate a unique referral code
       * Save it to the customer
     * If already exists:

       * Return the existing code (do NOT generate a new one)
   * Return a link like:

```text
https://yourapp.com/register?referral_code=XXXX
```

3. **Registration with Referral Code:**

   * The registration endpoint should:

     * Accept `referral_code`
     * Check if it exists in `customers` table
   * If valid:

     * Add referral points to the **referrer**

4. **Constraints & Rules:**

   * Referral code must be:

     * Unique
     * Short (6–8 chars)
   * Prevent:

     * Using invalid codes
   * Use DB transactions for consistency

5. **Edge Cases:**

   * User tries to generate multiple codes → reuse existing one

---

### Expected Output:

1. Migration (ensure `referral_code` is nullable + unique)


1. Migration (IMPORTANT - Production Safe)
Create a new migration to add a referral_code column to the customers table.
The column should be:
Unique
Nullable initially (to avoid breaking existing data)
Ensure the migration is safe for production systems.