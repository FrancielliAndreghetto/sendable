"use client";

import LoadingOverlay from "@/components/LoadingOverlay";
import useAuthUser from "@/hooks/store/auth/useAuthUser";
import { WrapperProps } from "@/types";
import { useRouter } from "next/navigation";
import { useEffect } from "react";
import { AppSidebar } from "@/components/app-sidebar";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";

const ContactsLayout = ({ children }: WrapperProps) => {
  const { isAuthenticated, isHydrated } = useAuthUser();
  const router = useRouter();

  useEffect(() => {
    if (isHydrated && !isAuthenticated) {
      router.push("/auth");
    }
  }, [isAuthenticated, isHydrated, router]);

  if (!isHydrated) {
    return <LoadingOverlay loading />;
  }

  if (!isAuthenticated) {
    return <LoadingOverlay loading />;
  }

  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        {children}
      </SidebarInset>
    </SidebarProvider>
  );
};

export default ContactsLayout;


