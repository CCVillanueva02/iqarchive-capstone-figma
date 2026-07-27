```
sequenceDiagram
    actor User
    participant App as IQArchive App
    participant Google as Google Identity Provider
    participant DB as Database

    User->>App: Clicks "Sign in with Google"
    App->>Google: Redirect to Google OAuth Consent Page
    User->>Google: Grant permissions & login
    Google->>App: Callback with User Details (Token, Email, Name)
    App->>App: Validate email ends with '@bicol-u.edu.ph'
    alt Email is Invalid
        App-->>User: Redirect to Login with error: "BU email required"
    else Email is Valid
        App->>DB: Find or Create User by email/google_id
        App->>User: Set auth session & redirect to Dashboard
    end
```

