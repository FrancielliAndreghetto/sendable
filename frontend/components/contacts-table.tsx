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

export default function TableDemo() {
  return (
    <div className="bg-gradient-to-b from-sidebar/60 to-sidebar p-3 rounded-2xl border border-border h-80">
      <h1 className="ml-2 my-4 text-lg font-semibold">Próximos Agendamentos</h1>
      <Table className="h-full">
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
  )
}
