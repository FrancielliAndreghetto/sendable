"use client";

import { memo, useCallback, useState } from "react";
import { useRouter } from "next/navigation";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import ForgotPasswordDialog from "@/components/dialogs/ForgotPasswordDialog";
import axios from "axios";
import { Tokens } from "@/types";
import useAuthUser from "@/hooks/store/auth/useAuthUser";

const SigninClient = () => {
  // Estados para o formulário:
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [remember, setRemember] = useState(false);
  const [processing, setProcessing] = useState(false);
  const [errors, setErrors] = useState<{ form?: string; email?: string; password?: string }>({});
  const [showForgotPasswordDialog, setShowForgotPasswordDialog] = useState(false);
  const router = useRouter();
  const { setToken, setUser } = useAuthUser();

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
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8080';
      const response = await axios.post(`${apiUrl}/api/auth/login`, {
        email,
        password,
        remember,
      });

      console.log('Login response:', response.data);

      const { token, user } = response.data.data;

      // Armazenar token no localStorage com a chave correta
      localStorage.setItem(Tokens.User, token);
      localStorage.setItem("user", JSON.stringify(user));

      // Atualizar o estado de autenticação
      setToken(token);
      setUser(user);

      console.log('Token stored:', localStorage.getItem(Tokens.User));

      alert("Login bem-sucedido!");
      router.push("/contacts");
    } catch (error: any) {
      console.error('Login error:', error);
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
          {errors.form && (
            <CardDescription className="text-red-500 text-center pt-2">{errors.form}</CardDescription>
          )}
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
              {errors.email && (
                <p className="text-red-500 text-xs mt-1">{errors.email}</p>
              )}
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
              {errors.password && (
                <p className="text-red-500 text-xs mt-1">{errors.password}</p>
              )}
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
