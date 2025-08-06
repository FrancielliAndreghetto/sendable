import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';

export function middleware(request: NextRequest) {
  // Pega o token do cookie da requisição
  const token = request.cookies.get('auth_token')?.value;

  // Pega a URL que o usuário está tentando acessar
  const { pathname } = request.nextUrl;

  // A página de login é a única exceção dentro de /auth
  const isAuthPage = pathname === '/auth';

  // Se o usuário tem um token e tenta acessar a página de login, redireciona para o dashboard
  if (token && isAuthPage) {
    return NextResponse.redirect(new URL('/auth/dashboard', request.url));
  }

  // Se não há token e o usuário tenta acessar qualquer rota protegida (que não seja a de login)
  if (!token && !isAuthPage && pathname.startsWith('/auth/')) {
    // Redireciona para a página de login
    const loginUrl = new URL('/auth', request.url);
    return NextResponse.redirect(loginUrl);
  }

  // Se nenhuma das condições acima for atendida, permite que a requisição continue
  return NextResponse.next();
}

// O 'matcher' define em quais rotas o middleware será executado
export const config = {
  matcher: ['/auth/:path*'],
};