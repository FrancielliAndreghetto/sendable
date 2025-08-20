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


export default function MessagesLayout(){
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
    return(
        <SidebarProvider>
            <AppSidebar />
                <SidebarInset className="overflow-hidden px-4 md:px-6 lg:px-8">
                <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
                    <div className="flex items-center justify-between gap-4">
                        <div className="space-y-1">
                            <h1 className="text-2xl font-semibold">Mensagens</h1>
                            <p className="text-sm text-muted-foreground">
                               Visualize e gerencie suas mensagens.
                            </p>
                        </div>
                        <div>
                            <div className="flex justify-center items-center gap-2">
                                <button className="bg-gradient-to-b from-sidebar/60 to-sidebar hover:from-sidebar/80 hover:to-sidebar/40 font-bold py-2.5 px-4 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={20} height={20} viewBox="0 0 24 24" fill="currentColor"><path d="M21 4V6H20L15 13.5V22H9V13.5L4 6H3V4H21ZM6.4037 6L11 12.8944V20H13V12.8944L17.5963 6H6.4037Z"></path></svg>
                                </button>
                                <button className="bg-gradient-to-r from-primary/40 to-primary/20 hover:from-primary/60 hover:to-primary/30 font-bold py-2 px-4 rounded">
                                    Agendar nova mensagem
                                </button>
                            </div>
                        </div>
                    </div>
                    <div className="bg-gradient-to-b from-sidebar/60 to-sidebar/40 p-3 rounded-2xl border border-border">  
                        <Table>
                            <TableHeader>
                            <TableRow>
                                <TableHead>Data/Hora</TableHead>
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
            </SidebarInset>
        </SidebarProvider>
    )
}