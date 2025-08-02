"use client";

import { memo, useCallback, useState } from "react";
import { useRouter } from "next/navigation";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import ForgotPasswordDialog from "@/components/dialogs/ForgotPasswordDialog";
import axios from "axios";
import Cookies from "js-cookie";

const SigninClient = () => {
  // Estados para o formulário:
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [remember, setRemember] = useState(false);
  const [processing, setProcessing] = useState(false);
  const [errors, setErrors] = useState<{ email?: string; password?: string }>({});
  const [showForgotPasswordDialog, setShowForgotPasswordDialog] = useState(false);
  const router = useRouter();

  // Abre diálogo de "esqueci senha"
  const handleOpenForgotPassword = useCallback(() => {
    setShowForgotPasswordDialog(true);
  }, []);

  // Função para enviar o formulário
  const handleSignin = async (e: React.FormEvent) => {
    e.preventDefault();
    setProcessing(true);
    setErrors({});

    try {
      const response = await axios.post("http://localhost:8080/api/auth/login", {
        email,
        password,
        remember,
      });

      const { token, user } = response.data.data;

      // Armazenar token no cookie e usuário no localStorage
      Cookies.set("auth_token", token, { expires: remember ? 7 : undefined, secure: process.env.NODE_ENV === 'production' });
      localStorage.setItem("user", JSON.stringify(user));

      alert("Login bem-sucedido!");
      router.push("/auth/dashboard");
    } catch (error: any) {
      if (error.response) {
        const message = error.response.data?.message || "Erro ao autenticar.";
        if (message.toLowerCase().includes("credenciais")) {
          setErrors({ email: message, password: message });
        } else {
          setErrors({ email: message });
        }
      } else {
        setErrors({ email: "Erro desconhecido" });
      }
    } finally {
      setProcessing(false);
    }
  };

  return (
    <>
      <Card className="w-full max-w-sm">
        <CardHeader>
          <CardTitle className="text-center">Sign In</CardTitle>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSignin} className="flex flex-col gap-4">
            <div>
              <label htmlFor="email" className="block font-medium mb-1">
                Email address
              </label>
              <input
                id="email"
                type="email"
                required
                autoFocus
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full border rounded px-3 py-2"
                placeholder="email@example.com"
                disabled={processing}
              />
            </div>

            <div>
              <label htmlFor="password" className="block font-medium mb-1">
                Password
              </label>
              <input
                id="password"
                type="password"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full border rounded px-3 py-2"
                placeholder="Password"
                disabled={processing}
              />
            </div>

            <div className="flex items-center space-x-2">
              <input
                id="remember"
                type="checkbox"
                checked={remember}
                onChange={() => setRemember(!remember)}
                disabled={processing}
              />
              <label htmlFor="remember" className="select-none">
                Remember me
              </label>
              <button
                type="button"
                className="ml-auto text-blue-600 hover:underline text-sm"
                onClick={handleOpenForgotPassword}
                disabled={processing}
              >
                Forgot password?
              </button>
            </div>

            <button
              type="submit"
              disabled={processing}
              className="mt-4 w-full bg-blue-600 text-white rounded py-2 disabled:opacity-50"
            >
              {processing ? "Loading..." : "Sign In"}
            </button>
          </form>
        </CardContent>
      </Card>

      <ForgotPasswordDialog open={showForgotPasswordDialog} onOpenChange={setShowForgotPasswordDialog} />
    </>
  );
};

export default memo(SigninClient);
