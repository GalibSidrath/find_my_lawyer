<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display error message if any -->
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    <form method="POST">
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter your email" required>
                        </div>
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter your password" required>
                        </div>
                        <!-- User Type Radio Buttons -->
                        <div class="mb-3">
                            <label class="form-label">I am a:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userType" id="generalUser"
                                    value="general_user" checked>
                                <label class="form-check-label" for="generalUser">General User</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userType" id="lawyer" value="lawyer_user">
                                <label class="form-check-label" for="lawyer">Lawyer</label>
                            </div>
                        </div>
                        <!-- Login Button -->
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>