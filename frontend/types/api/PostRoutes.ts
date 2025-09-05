export enum PostRoutes {
  SigninUser = "/auth/login",
  SignupUser = "/auth/signup",
  ForgotPasswordUser = "/auth/forgot-password",
  ResetPasswordUser = "/auth/reset-password",
  VerifyOtpUser = "/auth/verify-otp",
  ResendOtpUser = "/auth/resend-otp",
  UserRefresh = "/auth/refresh",
  OAuthSignIn = "/auth/oauth-2",
  CreateContact = "/whatsapp/contacts",
  CreateInstance = "/whatsapp/instances",

  AdminSignin = "/admin/auth",
  AdminRefresh = "/admin/auth/refresh",
}
export enum PostRoutesWithParams {
  test = "/test/:id",
}
