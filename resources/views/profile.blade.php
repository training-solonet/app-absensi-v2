<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }

        .page-title {
            font-weight: 700;
            margin: 24px 0;
            color: #2b2f38;
        }

        .card-soft {
            background: #fff;
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(20, 22, 36, .06);
        }

        .card-section {
            margin-bottom: 18px;
        }

        .summary {
            padding: 20px;
        }

        .summary .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9eef8;
        }

        .summary .name {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .summary .meta {
            color: #6b7280;
            font-size: .9rem;
        }

        .section-header {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            margin: 0;
            font-weight: 600;
            color: #334155;
        }

        .edit-btn {
            background: #ff8a3d;
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .info-grid {
            padding: 16px;
        }

        .info-label {
            color: #6b7280;
            font-size: .85rem;
            margin-bottom: 4px;
        }

        .info-value {
            color: #0f172a;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <h4 class="page-title">My Profile</h4>

        <!-- Summary -->
        <div class="card-soft summary card-section">
            <div class="d-flex align-items-center gap-3">
                <img class="avatar" src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Avatar">
                <div class="flex-grow-1">
                    <div class="name">Administrator</div>
                    <div class="meta">Admin • Solo, Indonesia</div>
                    <div class="meta">{{ session('user_email', 'admin@gmail.com') }}</div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card-soft card-section">
            <div class="section-header">
                <h6 class="section-title mb-0">Personal Information</h6>
                <button class="edit-btn"><i class="bi bi-pencil-square"></i> Edit</button>
            </div>
            <div class="info-grid">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-label">First Name</div>
                        <div class="info-value">Admin</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Last Name</div>
                        <div class="info-value">User</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value">01-01-1990</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ session('user_email', 'admin@gmail.com') }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">(+62) 821-0000-0000</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">User Role</div>
                        <div class="info-value">Admin</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address -->
        <div class="card-soft card-section">
            <div class="section-header">
                <h6 class="section-title mb-0">Address</h6>
                <button class="edit-btn"><i class="bi bi-pencil"></i> Edit</button>
            </div>
            <div class="info-grid">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-label">Country</div>
                        <div class="info-value">Indonesia</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">City</div>
                        <div class="info-value">Solo</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Postal Code</div>
                        <div class="info-value">57100</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
