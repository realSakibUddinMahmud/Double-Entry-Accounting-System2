# Comprehensive QA Test Cases - Double-Entry Accounting System

## Overview
This document contains comprehensive test cases for the Laravel-based fintech web application implementing double-entry accounting with Bangladesh-specific business rules.

---

## Table of Contents
1. [Authentication Module](#authentication-module)
2. [User Management](#user-management)
3. [Customer Management](#customer-management)
4. [Supplier Management](#supplier-management)
5. [Product Management](#product-management)
6. [Store Management](#store-management)
7. [Double-Entry Accounting Module](#double-entry-accounting-module)
8. [Reports and Exports](#reports-and-exports)
9. [Role-Based Access Control](#role-based-access-control)
10. [Security and Data Integrity](#security-and-data-integrity)

---

## Authentication Module

### 1. User Registration

#### Test Case ID: REG-001
**Feature**: User Registration (Phone Number Validation)
**Preconditions**: User is on registration page
**Steps**: 
1. Navigate to registration form
2. Enter phone number in phone field
3. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- `01712345678` → Registration successful
- `01812345678` → Registration successful  
- `01312345678` → Registration successful
- `01412345678` → Registration successful
- `01512345678` → Registration successful
- `01612345678` → Registration successful
- `01912345678` → Registration successful
- `+8801712345678` → Registration successful
- `+8801812345678` → Registration successful

*Invalid Inputs:*
- `01012345678` → Error "Invalid mobile operator prefix"
- `01112345678` → Error "Invalid mobile operator prefix"  
- `01212345678` → Error "Invalid mobile operator prefix"
- `0171234567` → Error "Phone number must be 11 digits"
- `017123456789` → Error "Phone number must be 11 digits"
- `+8801212345678` → Error "Invalid mobile operator prefix"
- `01712345abc` → Error "Phone number must be numeric"
- `abc1234567890` → Error "Invalid phone number format"
- `+88017123456789` → Error "Invalid format - too many digits"
- `` (empty) → Error "Phone number is required"

#### Test Case ID: REG-002  
**Feature**: User Registration (Name Validation)
**Preconditions**: User is on registration page
**Steps**:
1. Navigate to registration form
2. Enter name in name field
3. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- `John Doe` → Registration successful
- `মোহাম্মদ রহিম` → Registration successful
- `John O'Connor` → Registration successful
- `A` → Registration successful (minimum boundary)

*Invalid Inputs:*
- `` (empty) → Error "Name is required"
- `<script>alert('xss')</script>` → Error "Invalid characters in name"
- String with 256+ characters → Error "Name must not exceed 255 characters"
- `John123` → Warning "Name contains numbers"

#### Test Case ID: REG-003
**Feature**: User Registration (Email Validation)  
**Preconditions**: User is on registration page
**Steps**:
1. Navigate to registration form
2. Enter email in email field
3. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- `user@example.com` → Registration successful
- `test.email+tag@domain.co.uk` → Registration successful
- `` (empty) → Registration successful (email is optional)

*Invalid Inputs:*
- `invalid-email` → Error "Please enter a valid email address"
- `@domain.com` → Error "Please enter a valid email address"  
- `user@` → Error "Please enter a valid email address"
- `user@domain` → Warning "Email domain may be invalid"
- Duplicate email → Error "Email already exists"

#### Test Case ID: REG-004
**Feature**: User Registration (Password Validation)
**Preconditions**: User is on registration page  
**Steps**:
1. Navigate to registration form
2. Enter password and confirm password
3. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- `Password123!` → Registration successful
- `12345678` → Registration successful (minimum 8 chars)
- `ComplexP@ssw0rd#2024` → Registration successful

*Invalid Inputs:*
- `1234567` → Error "Password must be at least 8 characters"
- `` (empty) → Error "Password is required"
- Password != Confirm Password → Error "Password confirmation does not match"
- `<script>` → Error "Invalid characters in password"

### 2. User Login

#### Test Case ID: LOGIN-001
**Feature**: User Login (Phone Number Authentication)
**Preconditions**: User account exists with phone number
**Steps**:
1. Navigate to login page
2. Enter phone number and password
3. Click Sign In

**Test Data & Expected Results**:

*Valid Inputs:*
- Valid phone `01712345678` + correct password → Login successful
- Valid phone `+8801712345678` + correct password → Login successful

*Invalid Inputs:*
- Valid phone + wrong password → Error "Invalid credentials"
- Invalid phone format + any password → Error "Invalid phone number"
- `` (empty) phone → Error "Phone number is required"
- `` (empty) password → Error "Password is required"

#### Test Case ID: LOGIN-002
**Feature**: Password Reset Request
**Preconditions**: User account exists
**Steps**:
1. Click "Forgot Password" link
2. Enter phone number for password reset
3. Submit request

**Test Data & Expected Results**:

*Valid Inputs:*
- Existing phone number → SMS sent with reset code
- `01712345678` → OTP sent to phone

*Invalid Inputs:*
- Non-existent phone → Error "Phone number not found"
- Invalid format → Error "Invalid phone number format"

---

## Customer Management

#### Test Case ID: CUST-001
**Feature**: Customer Creation
**Preconditions**: User logged in with customer-create permissions
**Steps**:
1. Navigate to Customers page
2. Click "Add Customer"
3. Fill customer details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Name: `Ahmed Hassan`, Phone: `01712345678`, Email: `ahmed@example.com` → Customer created successfully
- Name: `রহিম উদ্দিন`, Phone: `01812345678`, Address: `ঢাকা, বাংলাদেশ` → Customer created successfully

*Invalid Inputs:*
- Empty name → Error "Name is required"
- Invalid phone `01012345678` → Error "Invalid mobile operator"
- Duplicate phone → Error "Phone number already exists"
- Invalid email format → Error "Invalid email address"
- Name > 255 chars → Error "Name too long"

#### Test Case ID: CUST-002
**Feature**: Customer Phone Number Validation
**Preconditions**: Adding/editing customer
**Steps**:
1. Enter phone number in customer form
2. Submit form

**Test Data & Expected Results**:

*Valid Bangladesh Numbers:*
- `01312345678` → Valid (Airtel)
- `01412345678` → Valid (Banglalink) 
- `01512345678` → Valid (Teletalk)
- `01612345678` → Valid (Airtel)
- `01712345678` → Valid (Grameenphone)
- `01812345678` → Valid (Robi)
- `01912345678` → Valid (Banglalink)

*Invalid Numbers:*
- `01012345678` → Error "Invalid operator prefix 010"
- `01112345678` → Error "Invalid operator prefix 011"
- `01212345678` → Error "Invalid operator prefix 012"
- `0202345678` → Error "Invalid format - must start with 01"

---

## Supplier Management

#### Test Case ID: SUPP-001
**Feature**: Supplier Creation
**Preconditions**: User logged in with supplier-create permissions
**Steps**:
1. Navigate to Suppliers page
2. Click "Add Supplier"  
3. Fill supplier details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Name: `ABC Trading Co.`, Contact Person: `Karim Ahmed`, Phone: `01712345678` → Supplier created
- Name: `XYZ Imports`, Phone: `01812345678`, Email: `xyz@trading.com` → Supplier created

*Invalid Inputs:*
- Empty name → Error "Supplier name is required"
- Invalid phone format → Error "Invalid phone number"
- Duplicate phone → Error "Phone number already exists"

---

## Product Management

#### Test Case ID: PROD-001
**Feature**: Product Creation
**Preconditions**: User logged in with product-create permissions, at least one store exists
**Steps**:
1. Navigate to Products page
2. Click "Add Product"
3. Fill product details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Name: `Rice 25kg`, SKU: `RICE001`, Price: `2500.50` → Product created
- Name: `Laptop Dell Inspiron`, Category: `Electronics`, Unit: `Piece` → Product created

*Invalid Inputs:*
- Empty name → Error "Product name is required"
- Empty store selection → Error "Store is required"
- Invalid price format → Error "Invalid price format"
- Negative price → Error "Price must be positive"
- Price > 999999999999.99 → Error "Price exceeds maximum limit"

#### Test Case ID: PROD-002  
**Feature**: Product Price Validation
**Preconditions**: Adding/editing product
**Steps**:
1. Enter price in product form
2. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- `100` → Valid
- `100.50` → Valid
- `0.01` → Valid (minimum)
- `999999999999.99` → Valid (maximum)

*Invalid Inputs:*
- `-50` → Error "Price cannot be negative"
- `abc` → Error "Price must be numeric"
- `100.999` → Error "Price can have maximum 2 decimal places"
- `` (empty) → Error "Price is required"

---

## Double-Entry Accounting Module

### Account Management

#### Test Case ID: ACC-001
**Feature**: Account Creation
**Preconditions**: User logged in with accounting permissions
**Steps**:
1. Navigate to DE Accounting > Accounts
2. Click "Create Account"
3. Fill account details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Title: `Cash in Hand`, Type: `Assets`, Account No: `10001` → Account created
- Title: `Bank Account - DBBL`, Type: `Assets`, Bank details filled → Bank account created

*Invalid Inputs:*
- Empty title → Error "Account title is required"
- Invalid account number format → Error "Invalid account number"
- Duplicate account number → Error "Account number already exists"

### Expense Management

#### Test Case ID: EXP-001
**Feature**: Expense Entry Creation
**Preconditions**: User logged in, source and destination accounts exist
**Steps**:
1. Navigate to DE Accounting > Expenses
2. Click "Create Expense"
3. Fill expense details with double-entry
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Amount: `5000.00`, From: `Cash Account`, To: `Office Rent Expense` → Expense recorded
- Amount: `1500.50`, Description: `Utility Bills`, Attachments: Valid PDF → Expense with attachments

*Invalid Inputs:*
- Amount: `0` → Error "Amount must be greater than zero"
- Amount: `-1000` → Error "Amount cannot be negative"
- Amount: `abc` → Error "Amount must be numeric"
- Missing source account → Error "Source account is required"
- Missing destination account → Error "Destination account is required"
- Amount > 14 digits → Error "Amount exceeds maximum limit"

#### Test Case ID: EXP-002
**Feature**: Expense Amount Validation (Double-Entry Integrity)
**Preconditions**: Creating expense entry
**Steps**:
1. Enter amount in expense form
2. Verify debit equals credit
3. Submit form

**Test Data & Expected Results**:

*Valid Amounts:*
- `1000` → Debit: 1000, Credit: 1000 (balanced)
- `1234.56` → Debit: 1234.56, Credit: 1234.56 (balanced)
- `99999999999.99` → Within maximum limit (14 characters including decimal)

*Invalid Amounts:*
- `1000000000000000` → Error "Amount exceeds maximum 14 characters"
- `1000.999` → Auto-corrected to `1000.99` (2 decimal places max)
- Non-numeric input → Error "Must be numeric"

### Income/Revenue Management

#### Test Case ID: INC-001
**Feature**: Income Entry Creation
**Preconditions**: User logged in, accounts exist
**Steps**:
1. Navigate to DE Accounting > Income/Revenue
2. Click "Create Income"  
3. Fill income details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Amount: `25000.00`, From: `Sales Revenue`, To: `Cash Account` → Income recorded
- Amount: `5000.75`, Description: `Service Income` → Income with description

*Invalid Inputs:*
- Same validation rules as expenses apply
- Double-entry integrity must be maintained

### Fund Transfer

#### Test Case ID: FTR-001
**Feature**: Fund Transfer Between Accounts
**Preconditions**: Multiple accounts exist
**Steps**:
1. Navigate to DE Accounting > Fund Transfer
2. Select source and destination accounts
3. Enter transfer amount
4. Submit transfer

**Test Data & Expected Results**:

*Valid Inputs:*
- From: `Cash Account`, To: `Bank Account`, Amount: `10000` → Transfer completed
- Between different account types → Transfer recorded with proper debits/credits

*Invalid Inputs:*
- Same source and destination → Error "Cannot transfer to same account"
- Insufficient balance (if balance checking enabled) → Error "Insufficient funds"
- Invalid amount → Same validation as other amount fields

### Loan & Investment Management

#### Test Case ID: LOAN-001
**Feature**: Loan/Investment Entry
**Preconditions**: User logged in, accounts exist
**Steps**:
1. Navigate to DE Accounting > Loan/Investment
2. Create loan or investment entry
3. Fill details with proper debit/credit accounts
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Loan Given: From `Cash` to `Loan Receivable`, Amount: `50000` → Loan recorded
- Investment: From `Cash` to `Investment Account`, Amount: `100000` → Investment recorded

*Invalid Inputs:*
- Standard amount validation applies
- Double-entry rules must be followed

#### Test Case ID: LOAN-002
**Feature**: Loan Return Entry
**Preconditions**: Loan exists in system
**Steps**:
1. Navigate to DE Accounting > Loan Return
2. Create loan return entry
3. Fill return details
4. Submit form

**Test Data & Expected Results**:

*Valid Inputs:*
- Return Amount: `10000`, From `Loan Receivable` to `Cash` → Return recorded

*Invalid Inputs:*
- Return amount > loan amount (if validation exists) → Error "Return exceeds loan amount"

### File Attachments

#### Test Case ID: ATT-001
**Feature**: File Attachments (All Accounting Modules)
**Preconditions**: Creating any accounting entry
**Steps**:
1. Select file attachments
2. Upload files
3. Submit form

**Test Data & Expected Results**:

*Valid Files:*
- `invoice.pdf` (PDF) → File uploaded successfully
- `receipt.jpg` (JPG) → File uploaded successfully  
- `document.jpeg` (JPEG) → File uploaded successfully
- `scan.png` (PNG) → File uploaded successfully
- Multiple valid files → All files uploaded

*Invalid Files:*
- `malware.exe` → Error "File type not allowed"
- `document.doc` → Error "Only PDF, JPG, JPEG, PNG allowed"
- File > size limit → Error "File size exceeds limit"
- Corrupt/invalid file → Error "Invalid file format"

---

## Reports and Exports

#### Test Case ID: REP-001
**Feature**: Journal Report Generation
**Preconditions**: Accounting transactions exist
**Steps**:
1. Navigate to DE Accounting > Journals
2. Set date range filters
3. Generate report
4. Export to PDF

**Test Data & Expected Results**:

*Valid Inputs:*
- Date range: Valid from/to dates → Report generated with transactions
- Export PDF → PDF file downloaded successfully

*Invalid Inputs:*
- From date > To date → Error "Invalid date range"
- Future dates → Warning "No data available for future dates"

#### Test Case ID: REP-002
**Feature**: Ledger Report Generation
**Preconditions**: Account transactions exist
**Steps**:
1. Navigate to DE Accounting > Ledger
2. Select account and date range
3. Generate ledger report
4. Export to PDF

**Test Data & Expected Results**:

*Valid Inputs:*
- Valid account + date range → Ledger report with running balance
- Export functionality → PDF downloaded

*Invalid Inputs:*
- No account selected → Error "Account selection required"
- Invalid date range → Error "Invalid date range"

#### Test Case ID: REP-003
**Feature**: Trial Balance Generation
**Preconditions**: Multiple accounts with transactions
**Steps**:
1. Navigate to Reports > Trial Balance
2. Set date range
3. Generate trial balance
4. Verify debit = credit totals

**Test Data & Expected Results**:

*Valid Scenarios:*
- All transactions → Trial balance with equal debit/credit totals
- Specific date range → Filtered trial balance

*Invalid Scenarios:*
- Unbalanced entries (system error) → Error "Trial balance does not match"

---

## Role-Based Access Control (RBAC)

#### Test Case ID: RBAC-001
**Feature**: Permission-Based Access Control
**Preconditions**: Different user roles exist
**Steps**:
1. Login with specific role
2. Try accessing restricted features
3. Verify access control

**Test Data & Expected Results**:

*Valid Access:*
- Admin role → Access to all features
- Accountant role → Access to accounting modules only
- Cashier role → Access to basic transaction entry

*Invalid Access:*
- Guest user → Error "Access denied"
- User without permissions → Error "Insufficient permissions"
- Expired session → Redirect to login

#### Test Case ID: RBAC-002
**Feature**: User Role Management
**Preconditions**: Admin user logged in
**Steps**:
1. Navigate to Users & Roles
2. Create/Edit user roles
3. Assign permissions
4. Test role functionality

**Test Data & Expected Results**:

*Valid Operations:*
- Create new role with specific permissions → Role created successfully
- Assign role to user → User gains role permissions

*Invalid Operations:*
- Circular role dependencies → Error "Invalid role hierarchy"
- Remove critical admin permissions → Warning "Admin access required"

---

## Security and Data Integrity Tests

#### Test Case ID: SEC-001
**Feature**: SQL Injection Prevention
**Preconditions**: Any form input
**Steps**:
1. Enter SQL injection attempts in input fields
2. Submit forms
3. Verify no database compromise

**Test Data & Expected Results**:

*Malicious Inputs:*
- `'; DROP TABLE users; --` → Input sanitized, no SQL execution
- `' OR '1'='1` → Query sanitized, normal validation
- `<script>alert('XSS')</script>` → Script tags removed/escaped

#### Test Case ID: SEC-002
**Feature**: XSS Prevention
**Preconditions**: Any form with text input
**Steps**:
1. Enter XSS attempts
2. Submit and view data
3. Verify scripts don't execute

**Test Data & Expected Results**:

*XSS Attempts:*
- `<script>alert('xss')</script>` → Script tags escaped/removed
- `javascript:alert('xss')` → JavaScript blocked
- `<img src=x onerror=alert('xss')>` → Malicious attributes removed

#### Test Case ID: SEC-003
**Feature**: CSRF Protection  
**Preconditions**: Any form submission
**Steps**:
1. Submit form without CSRF token
2. Submit with invalid token
3. Verify protection active

**Test Data & Expected Results**:

*Security Tests:*
- Missing CSRF token → Error "Token mismatch"
- Invalid/expired token → Error "Token invalid"
- Valid token → Form submission successful

#### Test Case ID: SEC-004
**Feature**: Double-Entry Accounting Integrity
**Preconditions**: Any accounting transaction
**Steps**:
1. Create accounting entries
2. Verify debit = credit for each transaction
3. Check overall ledger balance

**Test Data & Expected Results**:

*Integrity Checks:*
- Every transaction → Total debits = Total credits
- Account balances → Sum of all account balances = 0
- Audit trail → All changes tracked and traceable

#### Test Case ID: SEC-005
**Feature**: Data Validation and Business Rules
**Preconditions**: Any data entry
**Steps**:
1. Test boundary conditions
2. Test business rule enforcement
3. Verify data consistency

**Test Data & Expected Results**:

*Business Rule Tests:*
- Account types → Proper debit/credit behavior
- Date validations → No future dates for historical entries
- Amount limits → Respect configured maximum amounts
- Required fields → All mandatory fields enforced

---

## End-to-End Workflow Testing

#### Test Case ID: E2E-001
**Feature**: Complete Accounting Workflow
**Preconditions**: Fresh system setup
**Steps**:
1. User registration with valid Bangladesh phone
2. Login and setup company profile
3. Create chart of accounts
4. Record initial capital investment
5. Create customer and supplier
6. Record purchase transaction
7. Record sales transaction  
8. Generate trial balance report
9. Export reports to PDF

**Test Data & Expected Results**:

*Complete Workflow:*
- Registration: `01712345678`, `admin@company.com` → User created
- Company Setup: `ABC Trading Ltd.` → Company profile created
- Accounts: Cash, Bank, Inventory, Sales, COGS → Chart of accounts created
- Initial Investment: `100000` → Capital account credited, Cash debited
- Purchase: `50000` inventory → Inventory debited, Cash credited
- Sale: `75000` revenue → Cash debited, Sales credited, COGS debited, Inventory credited
- Trial Balance → Debits = Credits, all transactions reflected
- PDF Export → All reports downloadable

*Expected Final State:*
- Trial balance balanced (∑Debits = ∑Credits)
- All transactions traceable through audit trail
- Reports accurate and complete
- Data integrity maintained throughout workflow

---

## Performance and Load Testing

#### Test Case ID: PERF-001
**Feature**: System Performance Under Load
**Preconditions**: System deployed
**Steps**:
1. Simulate multiple concurrent users
2. Test with large datasets
3. Monitor response times

**Test Data & Expected Results**:

*Performance Benchmarks:*
- 50 concurrent users → Response time < 3 seconds
- 10,000 transactions → Report generation < 30 seconds
- Large file uploads → Progress indication and successful completion

---

## Browser and Device Compatibility

#### Test Case ID: COMPAT-001
**Feature**: Cross-Browser Compatibility
**Preconditions**: Application deployed
**Steps**:
1. Test on different browsers
2. Test responsive design
3. Verify functionality consistency

**Test Data & Expected Results**:

*Browser Tests:*
- Chrome, Firefox, Safari, Edge → All features work correctly
- Mobile devices → Responsive design functions properly
- Different screen sizes → UI remains usable

---

## Data Backup and Recovery

#### Test Case ID: BCK-001
**Feature**: Data Backup and Recovery
**Preconditions**: System with data
**Steps**:
1. Create system backup
2. Simulate data loss
3. Restore from backup
4. Verify data integrity

**Test Data & Expected Results**:

*Backup Tests:*
- Regular backups → Data successfully backed up
- Recovery process → Data restored completely
- Integrity check → All accounting equations still balanced

---

## Localization and Language Support  

#### Test Case ID: LOC-001
**Feature**: Bengali Language Support
**Preconditions**: System supports Bengali
**Steps**:
1. Enter Bengali text in forms
2. Generate reports with Bengali content
3. Verify proper display and PDF export

**Test Data & Expected Results**:

*Bengali Support:*
- Names: `মোহাম্মদ রহিম উদ্দিন` → Properly displayed and stored
- Addresses: `ঢাকা, বাংলাদেশ` → Correct rendering
- PDF exports → Bengali text properly rendered in PDFs

---

## Summary

This comprehensive test suite covers:
- **170+ input forms** across main application
- **46+ accounting module forms** 
- **Bangladesh-specific phone validation** (013-019 prefixes)
- **Double-entry accounting integrity** (Debit = Credit)
- **Security testing** (SQL injection, XSS, CSRF)
- **End-to-end workflows** from registration to reporting
- **Performance and compatibility** testing
- **Data integrity and business rules** validation

Each test case follows the structure:
- Feature Name
- Test Case ID  
- Preconditions
- Steps to Execute
- Test Data (Valid & Invalid)
- Expected Results

The test cases ensure comprehensive coverage of all functionality while maintaining focus on Bangladesh business rules and double-entry accounting principles.
| 01712345678 | Registration successful, user created |
| 01812345678 | Registration successful, user created |
| 01912345678 | Registration successful, user created |
| 01612345678 | Registration successful, user created |
| 01512345678 | Registration successful, user created |
| 01412345678 | Registration successful, user created |
| 01312345678 | Registration successful, user created |
| +8801712345678 | Registration successful, user created |
| +8801812345678 | Registration successful, user created |

##### Invalid Phone Numbers:
| Input | Expected Result |
|-------|----------------|
| 01012345678 | Error: "Invalid mobile operator prefix" |
| 01112345678 | Error: "Invalid mobile operator prefix" |
| 01212345678 | Error: "Invalid mobile operator prefix" |
| 0171234567 | Error: "Phone number must be 11 digits" |
| 017123456789 | Error: "Phone number must be 11 digits" |
| +8801012345678 | Error: "Invalid mobile operator prefix" |
| +8801212345678 | Error: "Invalid mobile operator prefix" |
| 01712345abc | Error: "Phone number must be numeric" |
| abc1712345678 | Error: "Phone number must be numeric" |
| 123456789 | Error: "Invalid phone number format" |
| +88017123456 | Error: "Invalid phone number length" |

##### Other Field Validations:
| Field | Valid Input | Invalid Input | Expected Result |
|-------|------------|---------------|----------------|
| Name | "John Doe" | "" (empty) | Error: "Name is required" |
| Name | "John Doe" | "a" (1 char) | Success |
| Name | "John Doe" | String of 256 chars | Error: "Name must not exceed 255 characters" |
| Email | "john@example.com" | "" (empty) | Success (optional field) |
| Email | "john@example.com" | "invalid-email" | Error: "Email must be valid" |
| Email | "john@example.com" | Existing email | Error: "Email already exists" |
| Password | "SecurePass123" | "" (empty) | Error: "Password is required" |
| Password | "SecurePass123" | "123" (< 8 chars) | Error: "Password must be at least 8 characters" |
| Password Confirm | "SecurePass123" | "DifferentPass" | Error: "Password confirmation does not match" |

#### Test Case ID: REG-002
**Feature**: User Registration - Duplicate Phone Prevention
**Preconditions**: User exists with phone number 01712345678
**Steps to Execute**:
1. Navigate to `/register`
2. Enter details with existing phone number
3. Submit form

**Test Data**: Phone: 01712345678 (existing)
**Expected Result**: Error: "Phone number already exists"

### 1.2 User Login

#### Test Case ID: LOGIN-001
**Feature**: User Login Form
**Preconditions**: User account exists with phone 01712345678 and password "SecurePass123"
**Steps to Execute**:
1. Navigate to `/login`
2. Enter login credentials
3. Submit form

**Test Data & Expected Results**:

##### Valid Login Scenarios:
| Phone | Password | Expected Result |
|-------|----------|----------------|
| 01712345678 | SecurePass123 | Login successful, redirect to dashboard |
| +8801712345678 | SecurePass123 | Login successful, redirect to dashboard |

##### Invalid Login Scenarios:
| Phone | Password | Expected Result |
|-------|----------|----------------|
| 01712345678 | WrongPassword | Error: "Invalid credentials" |
| 01812345678 | SecurePass123 | Error: "Invalid credentials" (non-existent user) |
| "" | SecurePass123 | Error: "Phone number is required" |
| 01712345678 | "" | Error: "Password is required" |
| 01012345678 | SecurePass123 | Error: "Invalid phone number format" |

#### Test Case ID: LOGIN-002
**Feature**: Remember Me Functionality
**Preconditions**: Valid user credentials available
**Steps to Execute**:
1. Navigate to `/login`
2. Enter valid credentials
3. Check "Remember me" checkbox
4. Submit form
5. Close browser and reopen
6. Navigate to protected page

**Expected Result**: User remains logged in after browser restart

#### Test Case ID: LOGIN-003
**Feature**: Password Reset Request
**Preconditions**: User exists with phone 01712345678
**Steps to Execute**:
1. Navigate to `/login`
2. Click "Forgot Password?" link
3. Enter phone number
4. Submit request

**Test Data**: Phone: 01712345678
**Expected Result**: Password reset link sent, confirmation message displayed

---

## 2. CHART OF ACCOUNTS MANAGEMENT

### 2.1 Account Creation

#### Test Case ID: ACCT-001
**Feature**: Create New Account
**Preconditions**: User logged in with account management permissions
**Steps to Execute**:
1. Navigate to Chart of Accounts
2. Click "Create New Account"
3. Fill account creation form
4. Submit form

**Test Data & Expected Results**:

##### Valid Account Data:
| Field | Valid Input | Expected Result |
|-------|------------|----------------|
| Account Type | "Assets" | Account created successfully |
| Account Title | "Cash in Hand" | Account created successfully |
| Account Code | "1001" | Account created successfully |
| Parent Account | "Current Assets" | Account created successfully |
| Opening Balance | "10000.50" | Account created with balance |

##### Invalid Account Data:
| Field | Invalid Input | Expected Result |
|-------|---------------|----------------|
| Account Title | "" (empty) | Error: "Account title is required" |
| Account Code | "1001" (duplicate) | Error: "Account code already exists" |
| Opening Balance | "abc123" | Error: "Balance must be numeric" |
| Opening Balance | "-1000" | Error: "Opening balance cannot be negative" |
| Account Type | "" (not selected) | Error: "Account type is required" |

#### Test Case ID: ACCT-002
**Feature**: Account Hierarchy Validation
**Preconditions**: Parent account "Current Assets" exists
**Steps to Execute**:
1. Create child account under "Current Assets"
2. Attempt to set the child account as parent of "Current Assets"

**Expected Result**: Error: "Circular reference not allowed in account hierarchy"

### 2.2 Account Balance Inquiry

#### Test Case ID: ACCT-003
**Feature**: View Account Balance
**Preconditions**: Account exists with transactions
**Steps to Execute**:
1. Navigate to Chart of Accounts
2. Click balance inquiry button for specific account
3. Verify balance calculation

**Expected Result**: Current balance displayed correctly based on all debit/credit transactions

---

## 3. JOURNAL ENTRIES

### 3.1 Journal Entry Creation

#### Test Case ID: JE-001
**Feature**: Create Journal Entry
**Preconditions**: At least 2 accounts exist in chart of accounts
**Steps to Execute**:
1. Navigate to Journal Entries
2. Click "Create New Entry"
3. Fill journal entry form
4. Submit entry

**Test Data & Expected Results**:

##### Valid Journal Entry:
| Field | Valid Input | Expected Result |
|-------|------------|----------------|
| Date | "2024-01-15" | Entry created successfully |
| Reference | "JE001" | Entry created successfully |
| Description | "Cash received from customer" | Entry created successfully |
| Debit Account | "Cash in Hand" | Entry created successfully |
| Debit Amount | "5000.00" | Entry created successfully |
| Credit Account | "Accounts Receivable" | Entry created successfully |
| Credit Amount | "5000.00" | Entry created successfully |

##### Invalid Journal Entry - Unbalanced:
| Debit Amount | Credit Amount | Expected Result |
|-------------|---------------|----------------|
| 5000.00 | 3000.00 | Error: "Debit and Credit amounts must be equal" |
| 5000.00 | "" (empty) | Error: "Credit amount is required" |
| "" (empty) | 5000.00 | Error: "Debit amount is required" |

##### Invalid Journal Entry - Amount Validation:
| Amount Input | Expected Result |
|-------------|----------------|
| "abc123" | Error: "Amount must be numeric" |
| "-1000" | Error: "Amount cannot be negative" |
| "0" | Error: "Amount must be greater than zero" |
| "999999999999999" (15 digits) | Error: "Amount exceeds maximum limit" |
| "1000.123" (3 decimal places) | Error: "Amount can have maximum 2 decimal places" |

#### Test Case ID: JE-002
**Feature**: Journal Entry File Attachments
**Preconditions**: Journal entry form is open
**Steps to Execute**:
1. Fill valid journal entry data
2. Attach files to journal entry
3. Submit entry

**Test Data & Expected Results**:

##### Valid File Types:
| File Type | File Size | Expected Result |
|-----------|-----------|----------------|
| invoice.jpg | 2MB | Upload successful |
| receipt.png | 1MB | Upload successful |
| document.pdf | 5MB | Upload successful |
| voucher.jpeg | 3MB | Upload successful |

##### Invalid File Types:
| File Type | Expected Result |
|-----------|----------------|
| malware.exe | Error: "File type not allowed" |
| document.docx | Error: "File type not allowed" |
| script.js | Error: "File type not allowed" |

##### File Size Validation:
| File Size | Expected Result |
|-----------|----------------|
| 15MB PDF | Error: "File size exceeds maximum limit" |
| 0KB file | Error: "File is empty" |

#### Test Case ID: JE-003
**Feature**: Multiple Journal Entry Lines
**Preconditions**: Multiple accounts exist
**Steps to Execute**:
1. Create journal entry with multiple debit/credit lines
2. Ensure total debits equal total credits
3. Submit entry

**Test Data**:
- Debit: Cash in Hand - 3000.00
- Debit: Bank Account - 2000.00  
- Credit: Sales Revenue - 4000.00
- Credit: Service Revenue - 1000.00
- Total Debits: 5000.00, Total Credits: 5000.00

**Expected Result**: Entry created successfully with all lines properly recorded

---

## 4. LEDGER MANAGEMENT

### 4.1 Ledger Inquiry

#### Test Case ID: LED-001
**Feature**: Account Ledger View
**Preconditions**: Account has multiple transactions
**Steps to Execute**:
1. Navigate to Ledgers
2. Select account from dropdown
3. Set date range
4. Click "View" button

**Test Data**:
- Account: "Cash in Hand"
- Start Date: "2024-01-01"
- End Date: "2024-01-31"

**Expected Result**: 
- All transactions for the account within date range displayed
- Running balance calculated correctly
- Transaction details (date, description, debit, credit, balance) shown

#### Test Case ID: LED-002
**Feature**: Ledger PDF Export
**Preconditions**: Ledger data is displayed
**Steps to Execute**:
1. View account ledger
2. Click "PDF" button
3. Verify PDF generation

**Expected Result**: 
- PDF file downloads successfully
- PDF contains all visible ledger data
- Formatting is professional and readable

#### Test Case ID: LED-003
**Feature**: Ledger Date Range Validation
**Preconditions**: User is on ledger inquiry page
**Steps to Execute**:
1. Enter invalid date ranges
2. Submit form

**Test Data & Expected Results**:
| Start Date | End Date | Expected Result |
|------------|----------|----------------|
| "2024-01-31" | "2024-01-01" | Error: "End date must be after start date" |
| "invalid-date" | "2024-01-31" | Error: "Invalid start date format" |
| "2024-01-01" | "invalid-date" | Error: "Invalid end date format" |
| "" (empty) | "2024-01-31" | Error: "Start date is required" |
| "2024-01-01" | "" (empty) | Error: "End date is required" |

---

## 5. FINANCIAL TRANSACTIONS

### 5.1 Income/Revenue Entry

#### Test Case ID: INC-001
**Feature**: Record Income/Revenue
**Preconditions**: Income and asset accounts exist
**Steps to Execute**:
1. Navigate to Income/Revenue section
2. Click "Create New Entry"
3. Fill income entry form
4. Submit entry

**Test Data & Expected Results**:

##### Valid Income Entry:
| Field | Valid Input | Expected Result |
|-------|------------|----------------|
| Source Account | "Sales Revenue" | Entry created successfully |
| Destination Account | "Cash in Hand" | Entry created successfully |
| Amount | "15000.50" | Entry created successfully |
| Date | "2024-01-15" | Entry created successfully |
| Description | "Product sales for January" | Entry created successfully |

##### Amount Validation:
| Amount Input | Expected Result |
|-------------|----------------|
| "0" | Error: "Amount must be greater than zero" |
| "99999999999999.99" | Error: "Amount exceeds maximum limit" |
| "1000.123" | Error: "Maximum 2 decimal places allowed" |
| "abc" | Error: "Amount must be numeric" |
| "-1000" | Error: "Amount cannot be negative" |

#### Test Case ID: INC-002
**Feature**: Income Entry Accounting Logic
**Preconditions**: Income entry is created
**Steps to Execute**:
1. Create income entry: Debit Cash 5000, Credit Sales Revenue 5000
2. Check journal entries
3. Verify account balances

**Expected Result**:
- Journal entry created with proper debit/credit
- Cash account balance increases by 5000
- Sales Revenue account balance increases by 5000
- Total debits equal total credits in trial balance

### 5.2 Expense Entry

#### Test Case ID: EXP-001
**Feature**: Record Expense
**Preconditions**: Expense and asset accounts exist
**Steps to Execute**:
1. Navigate to Expense section
2. Click "Create New Entry"
3. Fill expense entry form
4. Submit entry

**Test Data**:
- From Account: "Cash in Hand"
- To Account: "Office Rent Expense"
- Amount: "8000.00"
- Description: "Monthly office rent"

**Expected Result**:
- Expense entry created successfully
- Journal entry: Debit Office Rent Expense 8000, Credit Cash in Hand 8000
- Cash balance decreases by 8000
- Expense account balance increases by 8000

#### Test Case ID: EXP-002
**Feature**: Expense Entry with Attachments
**Preconditions**: User is creating expense entry
**Steps to Execute**:
1. Fill valid expense data
2. Upload supporting documents
3. Submit entry

**Test Data**:
- Receipt.jpg (2MB)
- Invoice.pdf (3MB)
- Bill.png (1MB)

**Expected Result**: Expense created with all attachments saved and accessible

### 5.3 Fund Transfer

#### Test Case ID: FT-001
**Feature**: Inter-Account Fund Transfer
**Preconditions**: Two asset accounts exist with sufficient balance
**Steps to Execute**:
1. Navigate to Fund Transfer
2. Select source and destination accounts
3. Enter transfer amount
4. Submit transfer

**Test Data**:
- From: "Cash in Hand" (Balance: 50000)
- To: "Bank Account"
- Amount: "25000"

**Expected Result**:
- Transfer created successfully
- Journal entry: Debit Bank Account 25000, Credit Cash in Hand 25000
- Cash in Hand balance decreases by 25000
- Bank Account balance increases by 25000

#### Test Case ID: FT-002
**Feature**: Fund Transfer - Insufficient Balance
**Preconditions**: Source account has balance less than transfer amount
**Steps to Execute**:
1. Attempt to transfer amount greater than available balance
2. Submit transfer

**Test Data**:
- From: "Cash in Hand" (Balance: 5000)
- Amount: "10000"

**Expected Result**: Error: "Insufficient balance in source account"

### 5.4 Loan & Investment

#### Test Case ID: LOAN-001
**Feature**: Record Loan Received
**Preconditions**: Liability and asset accounts exist
**Steps to Execute**:
1. Navigate to Loan/Investment
2. Create loan received entry
3. Fill loan details
4. Submit entry

**Test Data**:
- From Account: "Bank Loan" (Liability)
- To Account: "Bank Account" (Asset)
- Amount: "100000.00"
- Terms: "12 months at 10% interest"

**Expected Result**:
- Loan entry created successfully
- Journal entry: Debit Bank Account 100000, Credit Bank Loan 100000
- Bank Account balance increases
- Bank Loan liability increases

#### Test Case ID: LOAN-002
**Feature**: Investment Entry
**Preconditions**: Investment and asset accounts exist
**Steps to Execute**:
1. Create investment entry
2. Fill investment details
3. Submit entry

**Test Data**:
- From Account: "Cash in Hand"
- To Account: "Investment in Stocks"
- Amount: "50000.00"

**Expected Result**:
- Investment recorded successfully
- Proper journal entries created
- Account balances updated correctly

### 5.5 Security Deposit

#### Test Case ID: SD-001
**Feature**: Record Security Deposit
**Preconditions**: Appropriate accounts exist
**Steps to Execute**:
1. Navigate to Security Deposit
2. Create security deposit entry
3. Fill deposit details
4. Submit entry

**Test Data**:
- From Account: "Cash in Hand"
- To Account: "Security Deposits Paid"
- Amount: "15000.00"
- Purpose: "Office lease security deposit"

**Expected Result**: Security deposit recorded with proper accounting entries

---

## 6. PAYMENT MANAGEMENT

### 6.1 Payment Processing

#### Test Case ID: PAY-001
**Feature**: Process Payment
**Preconditions**: Payable accounts and cash accounts exist
**Steps to Execute**:
1. Navigate to Payment section
2. Create new payment
3. Select payee and amount
4. Process payment

**Test Data**:
- Payee Account: "Accounts Payable"
- Payment Account: "Bank Account"
- Amount: "12000.00"
- Payment Method: "Bank Transfer"

**Expected Result**:
- Payment processed successfully
- Accounts Payable balance decreases
- Bank Account balance decreases
- Payment recorded in payment register

#### Test Case ID: PAY-002
**Feature**: Payment Validation
**Preconditions**: User is creating payment
**Steps to Execute**:
1. Enter invalid payment data
2. Submit payment

**Test Data & Expected Results**:
| Field | Invalid Input | Expected Result |
|-------|---------------|----------------|
| Amount | "0" | Error: "Payment amount must be greater than zero" |
| Amount | Exceeds payable balance | Error: "Payment exceeds outstanding balance" |
| Payment Date | Future date | Error: "Payment date cannot be in the future" |
| Payment Account | "" (not selected) | Error: "Payment account is required" |

---

## 7. REPORTING

### 7.1 Trial Balance Report

#### Test Case ID: RPT-001
**Feature**: Generate Trial Balance
**Preconditions**: Multiple accounts with transactions exist
**Steps to Execute**:
1. Navigate to Reports > Trial Balance
2. Select date range
3. Generate report

**Test Data**:
- Date: "2024-01-31"

**Expected Result**:
- All accounts with balances displayed
- Total debits equal total credits
- Account balances calculated correctly
- Report format is professional

#### Test Case ID: RPT-002
**Feature**: Trial Balance PDF Export
**Preconditions**: Trial balance is displayed
**Steps to Execute**:
1. View trial balance report
2. Click "PDF" button
3. Verify PDF generation

**Expected Result**:
- PDF downloads successfully
- Contains all trial balance data
- Maintains formatting and readability
- Total debits and credits are clearly shown

#### Test Case ID: RPT-003
**Feature**: Trial Balance Drill-Down
**Preconditions**: Trial balance with account links displayed
**Steps to Execute**:
1. Click on account balance in trial balance
2. Verify drill-down to account transactions

**Expected Result**: Account transaction detail page opens showing all transactions for the selected account

### 7.2 Balance Sheet Report

#### Test Case ID: RPT-004
**Feature**: Generate Balance Sheet
**Preconditions**: Accounts classified as Assets, Liabilities, and Equity exist
**Steps to Execute**:
1. Navigate to Reports > Balance Sheet
2. Select date
3. Generate report

**Expected Result**:
- Assets section shows all asset accounts with balances
- Liabilities section shows all liability accounts with balances
- Equity section shows equity accounts
- Total Assets = Total Liabilities + Equity

#### Test Case ID: RPT-005
**Feature**: Balance Sheet Date Validation
**Preconditions**: User is on balance sheet page
**Steps to Execute**:
1. Enter invalid dates
2. Generate report

**Test Data & Expected Results**:
| Date Input | Expected Result |
|------------|----------------|
| Future date | Error: "Date cannot be in the future" |
| "invalid-date" | Error: "Invalid date format" |
| "" (empty) | Error: "Date is required" |

### 7.3 Account Transaction Report

#### Test Case ID: RPT-006
**Feature**: Account Transaction Detail Report
**Preconditions**: Account has multiple transactions
**Steps to Execute**:
1. Navigate to account transactions report
2. Select account and date range
3. Generate report

**Test Data**:
- Account: "Cash in Hand"
- Start Date: "2024-01-01"
- End Date: "2024-01-31"

**Expected Result**:
- All transactions for the account within date range
- Running balance calculation
- Transaction details (date, reference, description, debit, credit, balance)

---

## 8. USER MANAGEMENT & RBAC

### 8.1 User Role Assignment

#### Test Case ID: USER-001
**Feature**: Assign Roles to User
**Preconditions**: Users and roles exist, current user has role assignment permission
**Steps to Execute**:
1. Navigate to Users management
2. Select user for role assignment
3. Assign/remove roles
4. Save changes

**Test Data**:
- User: "John Doe"
- Roles: "Accountant", "Report Viewer"

**Expected Result**: User roles updated successfully, user gains/loses permissions accordingly

#### Test Case ID: USER-002
**Feature**: User Status Toggle
**Preconditions**: Active user exists
**Steps to Execute**:
1. Navigate to Users list
2. Click "Deactivate" button for user
3. Verify user status change

**Expected Result**: 
- User status changes to "Inactive"
- User cannot log in while inactive
- Status badge updates in UI

### 8.2 Permission Enforcement

#### Test Case ID: PERM-001
**Feature**: Unauthorized Access Prevention
**Preconditions**: User without specific permissions logged in
**Steps to Execute**:
1. Attempt to access restricted functionality
2. Verify system response

**Test Scenarios**:
| User Role | Attempted Action | Expected Result |
|-----------|------------------|----------------|
| "Report Viewer" | Create Journal Entry | 403 Forbidden, access denied message |
| "Data Entry" | Delete Journal Entry | 403 Forbidden, access denied message |
| "Guest" | View Financial Reports | Redirect to login page |

#### Test Case ID: PERM-002
**Feature**: Permission-Based UI Elements
**Preconditions**: User with limited permissions logged in
**Steps to Execute**:
1. Navigate to various pages
2. Verify UI elements match user permissions

**Expected Result**: Only permitted actions/buttons visible to user

---

## 9. DATA INTEGRITY & ACCOUNTING RULES

### 9.1 Double-Entry Validation

#### Test Case ID: DE-001
**Feature**: Double-Entry Rule Enforcement
**Preconditions**: System is functional
**Steps to Execute**:
1. Attempt to create unbalanced journal entry
2. Verify system prevents creation

**Test Data**:
- Debit: Cash 5000
- Credit: Sales 3000 (Unbalanced by 2000)

**Expected Result**: Error: "Total debits must equal total credits"

#### Test Case ID: DE-002
**Feature**: Account Balance Consistency
**Preconditions**: Multiple transactions exist
**Steps to Execute**:
1. Create several transactions
2. Check account balances
3. Verify trial balance totals

**Expected Result**: 
- Individual account balances match transaction history
- Trial balance total debits equal total credits
- Balance sheet balances (Assets = Liabilities + Equity)

### 9.2 Data Validation Rules

#### Test Case ID: DV-001
**Feature**: Numeric Field Validation
**Preconditions**: User is entering financial data
**Steps to Execute**:
1. Enter various numeric formats in amount fields
2. Submit forms

**Test Data & Expected Results**:
| Input | Expected Result |
|-------|----------------|
| "1,000.50" | Accepted (formatted number) |
| "1000.5" | Accepted (decimal number) |
| "1000" | Accepted (whole number) |
| ".50" | Accepted (decimal only) |
| "1000." | Accepted (trailing decimal) |
| "abc" | Error: "Must be numeric" |
| "1000.123" | Error: "Maximum 2 decimal places" |
| "999999999999999" | Error: "Amount too large" |

#### Test Case ID: DV-002
**Feature**: Date Field Validation
**Preconditions**: User is entering dates
**Steps to Execute**:
1. Enter various date formats
2. Submit forms

**Test Data & Expected Results**:
| Input | Expected Result |
|-------|----------------|
| "2024-01-15" | Accepted |
| "15/01/2024" | Accepted (if format supported) |
| "15-Jan-2024" | Accepted (if format supported) |
| "2024-02-30" | Error: "Invalid date" |
| "2024-13-01" | Error: "Invalid month" |
| "invalid" | Error: "Invalid date format" |

---

## 10. SECURITY TESTING

### 10.1 Input Sanitization

#### Test Case ID: SEC-001
**Feature**: SQL Injection Prevention
**Preconditions**: User has form access
**Steps to Execute**:
1. Enter SQL injection payloads in form fields
2. Submit forms
3. Verify system response

**Test Data**:
- `'; DROP TABLE users; --`
- `' OR '1'='1`
- `<script>alert('XSS')</script>`
- `'; UPDATE accounts SET balance = 999999; --`

**Expected Result**: 
- Input is sanitized/escaped
- No SQL injection occurs
- System remains secure
- Error message or sanitized input processing

#### Test Case ID: SEC-002
**Feature**: XSS Prevention
**Preconditions**: User can input text data
**Steps to Execute**:
1. Enter XSS payloads in text fields
2. Submit and view data
3. Verify script execution prevention

**Test Data**:
- `<script>alert('XSS')</script>`
- `<img src=x onerror=alert('XSS')>`
- `javascript:alert('XSS')`

**Expected Result**: Scripts do not execute, content is escaped/sanitized

### 10.2 Session Security

#### Test Case ID: SEC-003
**Feature**: Session Timeout
**Preconditions**: User is logged in
**Steps to Execute**:
1. Log in to system
2. Remain idle for session timeout period
3. Attempt to perform action

**Expected Result**: Session expires, user redirected to login page

#### Test Case ID: SEC-004
**Feature**: CSRF Protection
**Preconditions**: Forms include CSRF tokens
**Steps to Execute**:
1. Remove CSRF token from form
2. Submit form
3. Verify protection

**Expected Result**: Error: "CSRF token mismatch" or similar security error

---

## 11. FILE UPLOAD & ATTACHMENT TESTING

### 11.1 File Upload Validation

#### Test Case ID: FILE-001
**Feature**: Supported File Type Upload
**Preconditions**: User is attaching files to transaction
**Steps to Execute**:
1. Select files of different types
2. Upload files
3. Verify acceptance

**Test Data & Expected Results**:
| File Type | Size | Expected Result |
|-----------|------|----------------|
| document.pdf | 2MB | Upload successful |
| receipt.jpg | 1MB | Upload successful |
| invoice.jpeg | 3MB | Upload successful |
| bill.png | 1.5MB | Upload successful |

#### Test Case ID: FILE-002
**Feature**: Unsupported File Type Rejection
**Preconditions**: User is uploading files
**Steps to Execute**:
1. Select unsupported file types
2. Attempt upload
3. Verify rejection

**Test Data & Expected Results**:
| File Type | Expected Result |
|-----------|----------------|
| malware.exe | Error: "File type not supported" |
| document.docx | Error: "File type not supported" |
| archive.zip | Error: "File type not supported" |
| script.js | Error: "File type not supported" |

#### Test Case ID: FILE-003
**Feature**: File Size Validation
**Preconditions**: User is uploading files
**Steps to Execute**:
1. Upload files of various sizes
2. Verify size limits

**Test Data & Expected Results**:
| File Size | Expected Result |
|-----------|----------------|
| 10MB PDF | Error: "File too large" |
| 0KB file | Error: "Empty file not allowed" |
| 5MB JPG | Upload successful (if within limit) |

### 11.2 File Security

#### Test Case ID: FILE-004
**Feature**: Malicious File Detection
**Preconditions**: User is uploading files
**Steps to Execute**:
1. Attempt to upload files with malicious content
2. Verify system protection

**Test Data**: Files containing:
- Executable code disguised as images
- PHP scripts with image extensions
- Files with double extensions

**Expected Result**: System rejects or quarantines malicious files

---

## 12. PERFORMANCE TESTING

### 12.1 Report Generation Performance

#### Test Case ID: PERF-001
**Feature**: Large Dataset Report Performance
**Preconditions**: Database has 10,000+ transactions
**Steps to Execute**:
1. Generate trial balance report
2. Measure response time
3. Verify report accuracy

**Performance Criteria**:
- Response time < 5 seconds for 10,000 transactions
- Memory usage remains stable
- Report data is accurate

#### Test Case ID: PERF-002
**Feature**: PDF Export Performance
**Preconditions**: Large report data exists
**Steps to Execute**:
1. Export large report to PDF
2. Measure generation time
3. Verify PDF quality

**Expected Result**: PDF generates within 10 seconds, maintains formatting

### 12.2 Database Performance

#### Test Case ID: PERF-003
**Feature**: Concurrent User Performance
**Preconditions**: Multiple user accounts exist
**Steps to Execute**:
1. Simulate multiple users creating transactions simultaneously
2. Monitor system performance
3. Verify data integrity

**Expected Result**: System handles concurrent users without data corruption or significant slowdown

---

## 13. MULTI-TENANCY TESTING

### 13.1 Tenant Isolation

#### Test Case ID: TENANT-001
**Feature**: Data Isolation Between Tenants
**Preconditions**: Multiple tenants exist with separate data
**Steps to Execute**:
1. Login as user from Tenant A
2. Attempt to access Tenant B data
3. Verify isolation

**Expected Result**: User can only access data from their own tenant, no cross-tenant data leakage

#### Test Case ID: TENANT-002
**Feature**: Tenant Database Switching
**Preconditions**: Multiple tenant databases configured
**Steps to Execute**:
1. Switch between tenant contexts
2. Verify correct database connection
3. Confirm data segregation

**Expected Result**: System correctly switches to appropriate tenant database, maintains data isolation

---

## 14. BACKUP & RECOVERY TESTING

### 14.1 Data Backup

#### Test Case ID: BACKUP-001
**Feature**: System Data Backup
**Preconditions**: System has transaction data
**Steps to Execute**:
1. Trigger backup process
2. Verify backup file creation
3. Check backup integrity

**Expected Result**: Backup created successfully, contains all necessary data

#### Test Case ID: BACKUP-002
**Feature**: Data Recovery
**Preconditions**: Valid backup file exists
**Steps to Execute**:
1. Simulate data loss
2. Restore from backup
3. Verify data integrity

**Expected Result**: All data restored correctly, system functions normally

---

## 15. BROWSER COMPATIBILITY

### 15.1 Cross-Browser Testing

#### Test Case ID: BROWSER-001
**Feature**: Chrome Browser Compatibility
**Preconditions**: Latest Chrome browser
**Steps to Execute**:
1. Access all major features in Chrome
2. Test form submissions
3. Verify JavaScript functionality

**Expected Result**: All features work correctly in Chrome

#### Test Case ID: BROWSER-002
**Feature**: Firefox Browser Compatibility
**Preconditions**: Latest Firefox browser
**Steps to Execute**:
1. Access all major features in Firefox
2. Test form submissions
3. Verify JavaScript functionality

**Expected Result**: All features work correctly in Firefox

#### Test Case ID: BROWSER-003
**Feature**: Safari Browser Compatibility
**Preconditions**: Latest Safari browser
**Steps to Execute**:
1. Access all major features in Safari
2. Test form submissions
3. Verify JavaScript functionality

**Expected Result**: All features work correctly in Safari

#### Test Case ID: BROWSER-004
**Feature**: Mobile Browser Compatibility
**Preconditions**: Mobile device or responsive testing tools
**Steps to Execute**:
1. Access system on mobile browsers
2. Test responsive design
3. Verify touch interactions

**Expected Result**: System is usable on mobile devices, responsive design works properly

---

## 16. API TESTING (If APIs exist)

### 16.1 REST API Validation

#### Test Case ID: API-001
**Feature**: API Authentication
**Preconditions**: API endpoints exist
**Steps to Execute**:
1. Call API without authentication
2. Call API with invalid credentials
3. Call API with valid credentials

**Expected Results**:
- Unauthenticated: 401 Unauthorized
- Invalid credentials: 403 Forbidden
- Valid credentials: 200 Success

#### Test Case ID: API-002
**Feature**: API Data Validation
**Preconditions**: API accepts transaction data
**Steps to Execute**:
1. Send valid transaction data via API
2. Send invalid transaction data via API
3. Verify responses

**Expected Result**: API properly validates data, returns appropriate responses

---

## Test Execution Priority

### High Priority (Critical Business Functions):
1. User Authentication (LOGIN-001, REG-001)
2. Journal Entry Creation (JE-001)
3. Double-Entry Validation (DE-001, DE-002)
4. Trial Balance (RPT-001)
5. Bangladeshi Phone Validation (REG-001 phone tests)

### Medium Priority (Important Features):
1. Expense/Income Recording (EXP-001, INC-001)
2. Fund Transfers (FT-001)
3. Account Management (ACCT-001)
4. Report Generation (RPT-002, RPT-004)
5. User Permissions (PERM-001, PERM-002)

### Low Priority (Nice-to-Have):
1. File Attachments (FILE-001, FILE-002)
2. Performance Testing (PERF-001, PERF-002)
3. Browser Compatibility (BROWSER-001-004)
4. API Testing (API-001, API-002)

## Test Environment Requirements

### Prerequisites:
- MySQL database with landlord and tenant schemas
- Laravel application fully configured
- Test data seeded (accounts, users, sample transactions)
- Multiple user roles configured
- File upload directories configured
- Email/SMS testing capabilities

### Test Data Setup:
1. **Users**: Admin, Accountant, Data Entry, Report Viewer
2. **Accounts**: Cash, Bank, Receivables, Payables, Revenue, Expenses
3. **Sample Transactions**: Various journal entries for testing
4. **Multiple Tenants**: For testing isolation

### Success Criteria:
- All High Priority tests pass: 100%
- All Medium Priority tests pass: 95%
- All Low Priority tests pass: 90%
- No critical security vulnerabilities
- Performance requirements met
- Double-entry accounting rules strictly enforced

---

*This comprehensive test plan covers all major features, forms, workflows, and validation scenarios in the Double-Entry Accounting System, with special attention to Bangladeshi phone number validation and double-entry accounting integrity rules.*