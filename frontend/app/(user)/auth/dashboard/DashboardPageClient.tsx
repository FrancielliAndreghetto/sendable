// app/(user)/auth/dashboard/DashboardPageClient.tsx
"use client";

import { AppSidebar } from "@/components/app-sidebar";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import { Separator } from "@/components/ui/separator";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@/components/ui/sidebar";
import { Button } from "@/components/ui/button";
import UserDropdown from "@/components/user-dropdown";
import FeedbackDialog from "@/components/feedback-dialog";
import TableDemo from "@/components/contacts-table";
import { RiScanLine } from "@remixicon/react";
import { StatsGrid } from "@/components/stats-grid";
import { ChartBarDefault } from "@/components/chart-bar-default";
import { useState } from "react";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"


export default function Page() {
  const [user, setUser] = useState(() => {
        const storedUser = localStorage.getItem('user');
        return storedUser ? JSON.parse(storedUser) : null;
    });
    const invoices = [
      {
        invoice: "10/07/2025 14:30",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Campanha de Marketing",
      },
      {
        invoice: "25/07/2025 09:15",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Campanha de Vendas",
      },
      {
        invoice: "28/07/2025 11:45",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Atendimento ao Cliente",
      },
      {
        invoice: "29/07/2025 16:20",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Próximo Lançamento",
      },
      {
        invoice: "31/07/2025 08:00",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Black Friday",
      },
      {
        invoice: "05/08/2025 10:30",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Teste de Produto",
      },
      {
        invoice: "06/08/2025 12:15",
        paymentStatus: "+55 51 98318-6148",
        totalAmount: "Whatsapp",
        paymentMethod: "Instância",
      },
    ]
  return (
    
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset className="overflow-hidden px-4 md:px-6 lg:px-8">
        <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
          {/* Page intro */}
          <div className="flex items-center justify-between gap-4">
            <div className="space-y-1">
              <h1 className="text-2xl font-semibold">Olá, {user.name}!</h1>
              <p className="text-sm text-muted-foreground">
                Bem-vindo a sua dashboard, aqui você pode gerenciar suas instâncias e visualizar estatísticas.
              </p>
            </div>
          </div>
          {/* Numbers */}
          <StatsGrid
            stats={[
              {
                title: "Mensagens enviadas hoje",
                value: "427",
                icon: (
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width={20}
                    height={20}
                    fill="currentColor"
                  >
                    <path d="M9 0v2.013a8.001 8.001 0 1 0 5.905 14.258l1.424 1.422A9.958 9.958 0 0 1 10 19.951c-5.523 0-10-4.478-10-10C0 4.765 3.947.5 9 0Zm10.95 10.95a9.954 9.954 0 0 1-2.207 5.329l-1.423-1.423a7.96 7.96 0 0 0 1.618-3.905h2.013ZM11.002 0c4.724.47 8.48 4.227 8.95 8.95h-2.013a8.004 8.004 0 0 0-6.937-6.937V0Z" />
                  </svg>
                ),
              },
              {
                title: "Instâncias conectadas",
                value: "10",
                icon: (
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width={18}
                    height={19}
                    fill="currentColor"
                  >
                    <path d="M2 9.5c0 .313.461.858 1.53 1.393C4.914 11.585 6.877 12 9 12c2.123 0 4.086-.415 5.47-1.107C15.538 10.358 16 9.813 16 9.5V7.329C14.35 8.349 11.827 9 9 9s-5.35-.652-7-1.671V9.5Zm14 2.829C14.35 13.349 11.827 14 9 14s-5.35-.652-7-1.671V14.5c0 .313.461.858 1.53 1.393C4.914 16.585 6.877 17 9 17c2.123 0 4.086-.415 5.47-1.107 1.069-.535 1.53-1.08 1.53-1.393v-2.171ZM0 14.5v-10C0 2.015 4.03 0 9 0s9 2.015 9 4.5v10c0 2.485-4.03 4.5-9 4.5s-9-2.015-9-4.5ZM9 7c2.123 0 4.086-.415 5.47-1.107C15.538 5.358 16 4.813 16 4.5c0-.313-.461-.858-1.53-1.393C13.085 2.415 11.123 2 9 2c-2.123 0-4.086.415-5.47 1.107C2.461 3.642 2 4.187 2 4.5c0 .313.461.858 1.53 1.393C4.914 6.585 6.877 7 9 7Z" />
                  </svg>
                ),
              },
              {
                title: "Falhas no envio",
                value: "0",
                icon: (
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width={20}
                    height={20}
                    fill="currentColor"
                  >
                    <path d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10 4.477 0 10 0Zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm3.833 3.337a.596.596 0 0 1 .763.067.59.59 0 0 1 .063.76c-2.18 3.046-3.38 4.678-3.598 4.897a1.5 1.5 0 0 1-2.122-2.122c.374-.373 2.005-1.574 4.894-3.602ZM15.5 9a1 1 0 1 1 0 2 1 1 0 0 1 0-2Zm-11 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2Zm2.318-3.596a1 1 0 1 1-1.414 1.414 1 1 0 0 1 1.414-1.414ZM10 3.5a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z" />
                  </svg>
                ),
              }
            ]}
          />
          {/* Table */}
          <div className="grid grid-cols-2 gap-3">
            <ChartBarDefault/>
            <div className="bg-gradient-to-b from-sidebar/60 to-sidebar p-3 rounded-2xl border border-border">
              <h1 className="ml-2 my-4 text-lg font-semibold">Próximos Agendamentos</h1>
              <Table wrapperClassName="h-80">
                <TableHeader>
                  <TableRow>
                    <TableHead className="w-[100px]">Data/Hora</TableHead>
                    <TableHead>Número</TableHead>
                    <TableHead>Instância</TableHead>
                    <TableHead className="text-right">Tipo</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {invoices.map((invoice) => (
                    <TableRow key={invoice.invoice}>
                      <TableCell className="font-medium">{invoice.invoice}</TableCell>
                      <TableCell>{invoice.paymentStatus}</TableCell>
                      <TableCell>{invoice.paymentMethod}</TableCell>
                      <TableCell className="text-right">{invoice.totalAmount}</TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          </div>
        </div>
      </SidebarInset>
    </SidebarProvider>
  );
}

