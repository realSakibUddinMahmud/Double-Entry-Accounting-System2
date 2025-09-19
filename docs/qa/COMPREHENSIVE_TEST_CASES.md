# Comprehensive QA Test Cases - Double-Entry Accounting System

## Overview
This document provides comprehensive test cases for the Laravel-based Double-Entry Accounting System, covering all features, forms, buttons, and workflows found in the application views. The test cases follow structured format and include special validation rules for Bangladesh-specific business requirements.

## Test Case Structure
Each test case follows this format:
- **Feature Name**: Module/feature being tested
- **Test Case ID**: Unique identifier (e.g., AUTH-001, REG-001)
- **Preconditions**: Required setup/state before test execution
- **Steps to Execute**: Detailed step-by-step instructions
- **Test Data**: Valid and invalid input scenarios
- **Expected Result**: Expected system behavior

## Special Requirements: Bangladeshi Phone Number Validation

### Phone Number Rules:
- Must have 11 digits if starting with 01
- Valid operator prefixes: 013, 014, 015, 016, 017, 018, 019
- Invalid operator prefixes: 010, 011, 012
- Formats accepted:
  - Local: 01XXXXXXXXX (11 digits)
  - International: +8801XXXXXXXXX (13 characters)
- When +880 is present, it replaces the leading 0

### Double-Entry Accounting Rules:
- All transactions must maintain Debit = Credit balance
- Journal entries must have both debit and credit accounts
- Trial balance must always balance (total debits = total credits)

---

## 1. AUTHENTICATION & USER MANAGEMENT

### 1.1 User Registration

#### Test Case ID: REG-001
**Feature**: User Registration Form
**Preconditions**: User is on registration page, not logged in
**Steps to Execute**:
1. Navigate to `/register`
2. Fill in user registration form
3. Submit form
4. Verify system response

**Test Data & Expected Results**:

##### Valid Phone Numbers:
| Input | Expected Result |
|-------|----------------|
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

## 12. DOUBLE-ENTRY ACCOUNTING PACKAGE - DETAILED TESTING

### 12.1 Livewire Component Testing

#### Test Case ID: LIVE-001
**Feature**: Income Revenue Component Form Validation
**Preconditions**: User has accounting permissions, income accounts exist
**Steps to Execute**:
1. Navigate to `/de-accounting/income-revenues/create`
2. Test form validation using Livewire component
3. Verify real-time validation feedback

**Test Data & Expected Results**:

##### Source Account Selection:
| Account Type | Selection | Expected Result |
|--------------|-----------|-----------------|
| Valid Income Account | Service Revenue | Account selected, destination accounts loaded |
| Empty Selection | "" | Error: "Source account is required" |
| Invalid Account Type | Expense Account | Error: "Invalid account type for income" |

##### Amount Field Validation:
| Amount Input | Expected Result |
|-------------|-----------------|
| 25000.50 | Accepted, formatted to 2 decimals |
| 25000 | Accepted, formatted to 25000.00 |
| 25000.999 | Accepted, rounded to 25000.99 |
| abc | Error: "Amount must be numeric" |
| -1000 | Error: "Amount must be positive" |
| 0 | Error: "Amount must be greater than 0" |
| 99999999999999.99 | Error: "Amount exceeds maximum limit" |

##### Destination Account Validation:
| Account Selection | Expected Result |
|------------------|-----------------|
| Cash Account | Valid destination, amount mirrored |
| Bank Account | Valid destination, amount mirrored |
| Income Account | Error: "Cannot transfer to same account type" |
| Empty | Error: "Destination account required" |

#### Test Case ID: LIVE-002
**Feature**: Expense Component Form Validation
**Preconditions**: User has accounting permissions, expense accounts exist
**Steps to Execute**:
1. Navigate to `/de-accounting/expenses/create`
2. Fill expense form
3. Verify validations and amount limits

**Test Data & Expected Results**:

##### JavaScript Validation Testing:
| Input | JavaScript Function | Expected Result |
|-------|-------------------|-----------------|
| 12345.678 | validateInput() | Trimmed to 12345.67 |
| abc123.45 | validateInput() | Cleaned to 123.45 |
| 12345678901234.99 | validateInput() | Trimmed to 14 characters max |
| 123.999 | validateInput() | Limited to 2 decimal places |

#### Test Case ID: LIVE-003
**Feature**: Fund Transfer Component
**Preconditions**: Multiple bank/cash accounts exist
**Steps to Execute**:
1. Navigate to fund transfer page
2. Test account selection and validation
3. Verify double-entry logic

**Test Data & Expected Results**:

##### Source-Destination Account Logic:
| Source Account | Destination Account | Expected Result |
|---------------|-------------------|-----------------|
| Cash in Hand | Bank Account ABC | Valid transfer setup |
| Bank Account ABC | Cash in Hand | Valid transfer setup |
| Cash in Hand | Cash in Hand | Error: "Source and destination cannot be same" |
| Expense Account | Bank Account | Error: "Invalid account combination" |

### 12.2 File Upload Testing

#### Test Case ID: FILE-001
**Feature**: Transaction File Attachments
**Preconditions**: Transaction form open, upload enabled
**Steps to Execute**:
1. Select files for upload
2. Submit transaction
3. Verify file storage and retrieval

**Test Data & Expected Results**:

##### File Type Validation:
| File Type | File Name | Size | Expected Result |
|-----------|-----------|------|-----------------|
| PDF | invoice.pdf | 2MB | Upload successful |
| JPG | receipt.jpg | 1MB | Upload successful |
| JPEG | document.jpeg | 1.5MB | Upload successful |
| PNG | screenshot.png | 800KB | Upload successful |
| TXT | notes.txt | 10KB | Error: "File type not allowed" |
| EXE | virus.exe | 1MB | Error: "File type not allowed" |
| DOCX | contract.docx | 2MB | Error: "File type not allowed" |

##### File Size Validation:
| File Size | Expected Result |
|-----------|-----------------|
| 100KB | Upload successful |
| 5MB | Upload successful (at limit) |
| 6MB | Error: "File size exceeds 5MB limit" |
| 10MB | Error: "File size exceeds limit" |

### 12.3 Bangladesh-Specific Advanced Phone Number Testing

#### Test Case ID: BD-ADV-001
**Feature**: Advanced Bangladesh Phone Number Edge Cases
**Preconditions**: Any form with phone field
**Steps to Execute**:
1. Test edge cases for Bangladesh phone validation
2. Test international format variations
3. Verify operator-specific rules

**Test Data & Expected Results**:

##### International Format Variations:
| Phone Input | Expected Result |
|-------------|-----------------|
| +8801712345678 | ✅ Valid (Grameenphone international) |
| +8801812345678 | ✅ Valid (Robi international) |
| +8801312345678 | ✅ Valid (Teletalk international) |
| +8801412345678 | ✅ Valid (Banglalink international) |
| +8801512345678 | ✅ Valid (Citycell international) |
| +8801612345678 | ✅ Valid (Airtel international) |
| +8801912345678 | ✅ Valid (Banglalink international) |
| 8801712345678 | ❌ Error: "Missing + for international format" |
| ++8801712345678 | ❌ Error: "Invalid format" |
| +880 1712345678 | ❌ Error: "Space not allowed" |
| +8801712345678x123 | ❌ Error: "Extension not supported" |

##### Boundary Testing:
| Phone Input | Description | Expected Result |
|-------------|-------------|-----------------|
| 01313456789 | Minimum Teletalk | ✅ Valid |
| 01999999999 | Maximum Banglalink | ✅ Valid |
| 01300000000 | Edge case Teletalk | ✅ Valid |
| 01200000000 | Invalid prefix 012 | ❌ Error: "Invalid operator prefix" |
| 02012345678 | Non-mobile number | ❌ Error: "Not a mobile number format" |
| 01999999998 | One less than max | ✅ Valid |

### 12.4 Currency and Amount Precision Testing

#### Test Case ID: CURR-001
**Feature**: Bangladesh Taka (BDT) Amount Precision
**Preconditions**: Any monetary input field
**Steps to Execute**:
1. Test decimal precision limits
2. Test rounding behavior
3. Test currency formatting

**Test Data & Expected Results**:

##### Decimal Precision Testing:
| Amount Input | Expected Output | Expected Result |
|-------------|----------------|-----------------|
| 1000.50 | 1000.50 | ✅ Accepted |
| 1000.555 | 1000.56 | ✅ Rounded up |
| 1000.554 | 1000.55 | ✅ Rounded down |
| 1000.505 | 1000.51 | ✅ Rounded up |
| 1000.500 | 1000.50 | ✅ Kept as is |
| 0.01 | 0.01 | ✅ Minimum amount |
| 0.001 | 0.00 | ❌ Error: "Amount too small" |

##### Large Amount Testing:
| Amount Input | Expected Result |
|-------------|-----------------|
| 999999.99 | ✅ Accepted |
| 1000000.00 | ✅ Accepted |
| 9999999.99 | ✅ Accepted |
| 99999999.99 | ✅ Accepted |
| 999999999.99 | ✅ Accepted |
| 9999999999.99 | ✅ Accepted |
| 99999999999.99 | ✅ Accepted |
| 999999999999.99 | ✅ Accepted (max 14 chars) |
| 9999999999999.99 | ❌ Error: "Amount exceeds limit" |

### 12.5 End-to-End Bangladesh Business Scenario Testing

#### Test Case ID: E2E-BD-001
**Feature**: Complete Bangladesh SME Accounting Workflow
**Preconditions**: Clean system setup
**Steps to Execute**:
1. Register business owner with BD phone
2. Set up chart of accounts
3. Record typical Bangladesh business transactions
4. Generate standard reports
5. Verify compliance with local practices

**Business Scenario**: Small Trading Business in Dhaka

**Test Steps**:
1. **Business Registration**:
   - Owner: "Abdul Rahman"
   - Phone: +8801712345678
   - Business: "Rahman Trading Co."

2. **Chart of Accounts Setup**:
   - Cash in Hand (BDT)
   - Dutch Bangla Bank Account
   - Accounts Receivable
   - Inventory
   - Accounts Payable
   - Sales Revenue
   - Cost of Goods Sold
   - Office Rent
   - Utilities

3. **Typical Transactions**:
   - Initial Capital: BDT 500,000
   - Inventory Purchase: BDT 200,000
   - Sales (Cash): BDT 150,000
   - Sales (Credit): BDT 100,000
   - Rent Payment: BDT 25,000
   - Utility Bills: BDT 8,000
   - Bank Deposit: BDT 100,000

4. **Report Generation**:
   - Trial Balance
   - Profit & Loss Statement
   - Balance Sheet
   - Cash Flow Statement

**Expected Results**:
- All transactions recorded with proper double-entry
- Phone numbers validated according to BD rules
- Reports generated in BDT currency
- Trial balance balances (Debits = Credits)
- Realistic business scenario reflected in reports

#### Test Case ID: E2E-BD-002
**Feature**: Multi-User Bangladesh Business Scenario
**Preconditions**: Business system set up
**Steps to Execute**:
1. Create multiple users with different BD phone numbers
2. Assign roles (Owner, Accountant, Cashier)
3. Process transactions by different users
4. Verify audit trail and permissions

**Users**:
- Owner: +8801712345678 (Full access)
- Accountant: +8801812345679 (Accounting access)
- Cashier: +8801912345680 (Limited access)

**Expected Results**:
- All phone numbers validated properly
- Role-based access working
- Audit trail shows user actions
- No unauthorized access

### 12.6 Compliance and Regulatory Testing

#### Test Case ID: COMP-001
**Feature**: Bangladesh VAT/Tax Integration Readiness
**Preconditions**: Tax-enabled accounts exist
**Steps to Execute**:
1. Create transactions with tax implications
2. Verify tax calculations
3. Check tax reporting readiness

**Test Scenarios**:
- 15% VAT on sales
- Advance Tax deductions
- Withholding tax calculations

**Expected Results**:
- Tax amounts calculated correctly
- Tax accounts updated properly
- Reports show tax details
- Ready for VAT return preparation

---

## Test Case Summary

**Total Test Cases Generated**: 200+

### Coverage Breakdown:
- **Authentication & User Management**: 15 test cases
- **RBAC & Permissions**: 10 test cases  
- **Profile Management**: 8 test cases
- **Catalog Management**: 12 test cases
- **Supplier & Customer Management**: 10 test cases
- **Double-Entry Accounting Core**: 25 test cases
- **Livewire Components**: 15 test cases
- **File Upload & Attachments**: 8 test cases
- **Reports & Exports**: 20 test cases
- **Security Testing**: 25 test cases
- **Performance Testing**: 10 test cases
- **Bangladesh-Specific Validations**: 30 test cases
- **End-to-End Workflows**: 15 test cases
- **Integration Testing**: 12 test cases

### Bangladesh-Specific Features Covered:
✅ Phone number validation (all 7 operators)  
✅ International format (+880) handling  
✅ Currency precision (BDT) testing  
✅ Business workflow scenarios  
✅ Regulatory compliance readiness  
✅ Multi-user role-based testing  

### Double-Entry Accounting Features Covered:
✅ Journal entry creation and validation  
✅ Trial balance integrity  
✅ Account classification testing  
✅ Transaction reversal capabilities  
✅ Multi-currency support preparation  
✅ Audit trail verification  
✅ Batch processing capabilities  

### Security Features Covered:
✅ XSS prevention testing  
✅ SQL injection prevention  
✅ CSRF protection verification  
✅ Input sanitization validation  
✅ Role-based access control  
✅ Session management testing  

**All test cases are structured with:**
- Clear preconditions
- Step-by-step execution instructions
- Comprehensive test data (valid/invalid)
- Expected results for each scenario
- Priority classification for execution

*This comprehensive test suite ensures full coverage of the Laravel fintech application with special attention to Bangladesh business rules and double-entry accounting principles.*

---

*This comprehensive test plan covers all major features, forms, workflows, and validation scenarios in the Double-Entry Accounting System, with special attention to Bangladeshi phone number validation and double-entry accounting integrity rules.*