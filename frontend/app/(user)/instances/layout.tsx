"use client";

import LoadingOverlay from "@/components/LoadingOverlay";
import useAuthUser from "@/hooks/store/auth/useAuthUser";
import { WrapperProps } from "@/types";
import { useRouter } from "next/navigation";
import { useEffect } from "react";
import { AppSidebar } from "@/components/app-sidebar";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";

const InstancesLayout = ({ children }: WrapperProps) => {
  const { isAuthenticated, isHydrated } = useAuthUser();
  const router = useRouter();

  useEffect(() => {
    console.log('InstancesLayout - isHydrated:', isHydrated, 'isAuthenticated:', isAuthenticated);
    
    if (isHydrated && !isAuthenticated) {
      console.log('InstancesLayout - Redirecting to /auth');
      router.push("/auth");
    }
  }, [isAuthenticated, isHydrated, router]);

  if (!isHydrated) {
    console.log('InstancesLayout - Not hydrated yet');
    return <LoadingOverlay loading />;
  }

  if (!isAuthenticated) {
    console.log('InstancesLayout - Not authenticated');
    return <LoadingOverlay loading />;
  }

  console.log('InstancesLayout - Rendering sidebar and content');
  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        {children}
      </SidebarInset>
    </SidebarProvider>
  );
};

export default InstancesLayout;


