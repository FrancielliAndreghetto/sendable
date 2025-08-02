import { AppSidebar } from "@/components/app-sidebar";
import TableDemo from "@/components/contacts-table";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";
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


export default function ApiKeysLayout(){
      const invoices = [
      {
        invoice: "Api Key de produção",
        paymentStatus: "93euyehwiu83948909w0eod0iewojw",
        totalAmount: "10 de Maio de 2025",
        paymentMethod: "Ativo",
      },
      {
        invoice: "Api Key de produção",
        paymentStatus: "93euyehwiu83948909w0eod0iewojw",
        totalAmount: "10 de Maio de 2025",
        paymentMethod: "Ativo",
      },
      {
        invoice: "Api Key de produção",
        paymentStatus: "93euyehwiu83948909w0eod0iewojw",
        totalAmount: "10 de Maio de 2025",
        paymentMethod: "Ativo",
      },
      {
        invoice: "Api Key de produção",
        paymentStatus: "93euyehwiu83948909w0eod0iewojw",
        totalAmount: "10 de Maio de 2025",
        paymentMethod: "Ativo",
      },
      {
        invoice: "Api Key de produção",
        paymentStatus: "93euyehwiu83948909w0eod0iewojw",
        totalAmount: "10 de Maio de 2025",
        paymentMethod: "Ativo",
      },
    ]
    return(
        <SidebarProvider>
            <AppSidebar />
                <SidebarInset className="overflow-hidden px-4 md:px-6 lg:px-8">
                <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
                    <div className="flex items-center justify-between gap-4">
                        <div className="space-y-1">
                            <h1 className="text-2xl font-semibold">Chaves de API</h1>
                            <p className="text-sm text-muted-foreground">
                               Visualize e gerencie suas chaves de API.
                            </p>
                        </div>
                    </div>
                    <div className="bg-gradient-to-b from-sidebar/60 to-sidebar p-3 rounded-2xl border border-border">  
                        <Table>
                            <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead >Api Key</TableHead>
                                <TableHead>Created At</TableHead>
                                <TableHead>Updated At</TableHead>
                                <TableHead className="text-right">Status</TableHead>
                            </TableRow>
                            </TableHeader>
                            <TableBody>
                            {invoices.map((invoice) => (
                                <TableRow key={invoice.invoice}>
                                <TableCell className="font-medium">{invoice.invoice}</TableCell>
                                <TableCell >{invoice.paymentStatus}</TableCell>
                                <TableCell>{invoice.totalAmount}</TableCell>
                                <TableCell>{invoice.totalAmount}</TableCell>
                                <TableCell className="text-right">{invoice.paymentMethod}</TableCell>
                                </TableRow>
                            ))}
                            </TableBody>
                        </Table>
                    </div>
                </div>
            </SidebarInset>
        </SidebarProvider>
    )
}