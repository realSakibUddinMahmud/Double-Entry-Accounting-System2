# Phase 4 Test Matrix

This matrix enumerates Valid, Invalid, and Boundary cases per module, with expected HTTP status, DB assertions, and side-effects. Use data providers to cover permutations. Ensure tenant isolation across all tests (distinct tenants; no cross-tenant reads/writes).

## Legend
- HTTP: expected HTTP status (or redirect)
- DB: assertDatabaseHas/Missing with key columns
- FX: side-effects (stock, tax, audits, permissions, views)

---

## Auth & Sessions
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Valid login | phone=019..., password=secret123 | 302 → /home | sessions row created | none |
| Invalid password | valid phone, wrong password | 302 → /login | no user mutation | none |
| Disabled user | status=false | 302 → /login | none | none |
| Password reset request | phone exists | 200/302 | OTP row/notification | email/SMS stub |

## RBAC / Permissions
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Authorized CRUD | role permits | 2xx | entity inserted/updated | audit row |
| Unauthorized CRUD | missing perm | 403 | no DB changes | none |

## Companies / Tenancy
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Domain routing | Host: 127.0.0.1 | 200 | n/a | tenant set current |
| Isolation | two tenants | 2xx | writes scoped to tenant DB | none |

## Catalog: Categories (Nested Set)
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create root/child | valid names | 201 | row with lft/rgt | audit |
| Invalid parent_id | non-existent | 422 | none | none |
| Boundary depth | deep nesting | 201 | consistent lft/rgt | none |

## Catalog: Units
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create base unit | name,symbol | 201 | row factor=1 | none |
| Conversion bounds | factor<=0 | 422 | none | none |

## Catalog: Brands
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | unique name | 201 | row | none |
| Duplicate | existing name | 422 | none | none |

## Catalog: Products
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | valid FKs, unique SKU | 201 | row | audit |
| Missing FK | bad category/brand | 422 | none | none |
| Duplicate SKU | same SKU | 422 | none | none |

## Taxes
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | 0<=rate<=100 | 201 | row | none |
| Invalid rate | negative/over 100 | 422 | none | none |

## Stores
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | name/address | 201 | row | default accounts created |
| Invalid | missing name | 422 | none | none |

## Suppliers
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | name,phone | 201 | row | payable account created |
| Invalid phone | too long | 422 | none | none |

## Customers
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create | name,phone | 201 | row | receivable account created |
| Invalid phone | empty | 422 | none | none |

## Product-Store Mapping (pivot)
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Map product | store,units,price,tax | 201 | pivot row | none |
| Invalid unit | FK missing | 422 | none | none |
| Tax method enum | invalid value | 422 | none | none |

## Purchases
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Happy path | one/many items | 201 | purchase + items | stock ↑, tax sum, audit |
| Negative qty | < 0 | 422 | none | none |
| Precision | high decimals | 201 | rounded totals | correct math |
| Payment variants | cash/credit/partial | 201 | due/paid fields | journals posted |

## Sales
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Happy path | one/many items | 201 | sale + items | stock ↓, COGS, audit |
| Insufficient stock | qty>available | 422 | none | none |
| Discounts/Tax | per-line | 201 | totals match | journals posted |

## Images (polymorphic)
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Attach | product image | 201 | image row | none |
| Detach | delete image | 204 | row removed | cascade respected |

## Custom Fields (polymorphic)
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Define field | model_type/key | 201 | field row | none |
| Apply value | model/value | 201 | value row | none |
| Delete | clean up | 204 | orphan cleanup | none |

## Audits
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Create/Update/Delete | any module | 2xx | audit rows old/new | indexed |

## Reports / Views
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Stock view | after purchase/sale | 200 | SELECT view rows | numbers match math |
| COGS avg | purchases posted | 200 | view avg matches | none |

## Exports
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| PDF | request export | 200 | n/a | bytes>0, text contains |
| CSV | request export | 200 | n/a | headers+rows parsed |

---

# Double-Entry Accounting (DA)

## Core invariants
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Double-entry | any journal | 201 | sum(debits)=sum(credits) | none |
| Reversal | reverse entry | 201 | reversing rows | period respected |

## Event postings
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Investment | capital in | 201 | journals | balances updated |
| Purchase | cash/credit/partial | 201 | journals | inventory/COGS unaffected here |
| Sales | cash/credit with COGS | 201 | journals | revenue/receivable/COGS |
| Returns | purchase/sales return | 201 | journals | stock adjust |
| PPE acquisition | asset add | 201 | journals | asset/cash/creditor |
| Expense | opex | 201 | journals | none |
| Other income | misc revenue | 201 | journals | none |
| Fund transfer | bank→cash etc. | 201 | journals | none |
| Drawings | owner withdraw | 201 | journals | equity change |
| Corporate deposit | deposit | 201 | journals | cash/equity |

## Statements / checks
| Case | Input | HTTP | DB | FX |
|---|---|---:|---|---|
| Trial balance | after postings | 200 | debits=credits | none |
| P&L → Equity | close period | 200 | retained earnings | none |
| Equation | anytime | n/a | A = L + E | none |

---

## Tenancy Isolation (applies to all modules)
- All CRUD and DA flows must not leak across tenants.
- Use two distinct tenants and assert isolation for SELECT/INSERT/UPDATE/DELETE.

---

## Artifacts
- JUnit: `storage/test-artifacts/junit.xml`
- HTML Coverage: `storage/coverage/index.html`