import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';

export function middleware(request: NextRequest) {
  // Simplesmente permite que todas as requisições continuem
  // A verificação de autenticação será feita nos layouts das páginas
  return NextResponse.next();
}

// Configuração para executar em todas as rotas
export const config = {
  matcher: ['/((?!api|_next/static|_next/image|favicon.ico).*)'],
};