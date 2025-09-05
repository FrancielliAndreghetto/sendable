import { useQuery } from "@tanstack/react-query";
import { createApiInstance } from "@/lib/api/createApiInstance";
import { GetRoutes } from "@/types/api/GetRoutes";

interface DashboardStats {
  totalMessages: number;
  totalContacts: number;
  totalInstances: number;
  connectedInstances: number;
  messagesToday: number;
  failedMessages: number;
}

interface GetDashboardStatsResponse {
  data: DashboardStats;
  message: string;
  success: boolean;
}

export const useGetDashboardStats = () => {
  return useQuery<GetDashboardStatsResponse>({
    queryKey: [GetRoutes.GetDashboardStats],
    queryFn: async () => {
      const api = createApiInstance();
      const response = await api.get(GetRoutes.GetDashboardStats);
      return response.data;
    },
  });
};
