"use client";

import LoadingOverlay from "@/components/LoadingOverlay";
import useAuthUser from "@/hooks/store/auth/useAuthUser";
import { WrapperProps } from "@/types";
import { useRouter } from "next/navigation";
import { useEffect } from "react";
import { AppSidebar } from "@/components/app-sidebar";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";

const DashboardLayout = ({ children }: WrapperProps) => {
  const { isAuthenticated, isHydrated } = useAuthUser();
  const router = useRouter();

  useEffect(() => {
    console.log('DashboardLayout - isHydrated:', isHydrated, 'isAuthenticated:', isAuthenticated);
    
    if (isHydrated && !isAuthenticated) {
      console.log('DashboardLayout - Redirecting to /auth');
      router.push("/auth");
    }
  }, [isAuthenticated, isHydrated, router]);

  if (!isHydrated) {
    console.log('DashboardLayout - Not hydrated yet');
    return <LoadingOverlay loading />;
  }

  if (!isAuthenticated) {
    console.log('DashboardLayout - Not authenticated');
    return <LoadingOverlay loading />;
  }

  console.log('DashboardLayout - Rendering sidebar and content');
  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        {children}
      </SidebarInset>
    </SidebarProvider>
  );
};

export default DashboardLayout;