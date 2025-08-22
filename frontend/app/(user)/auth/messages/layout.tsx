import { AppSidebar } from "@/components/app-sidebar";
import { MessagesContent } from "@/components/pages/MessagesContent";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";

export default function MessagesLayout(){
  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <MessagesContent />
      </SidebarInset>
    </SidebarProvider>
  );
}