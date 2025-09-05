import { GET } from "@/lib/api";
import { IInstance } from "@/types";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useQuery } from "@tanstack/react-query";

interface GetInstancesResponse {
  success: boolean;
  message: string;
  data: IInstance[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    next_page_url: string | null;
    prev_page_url: string | null;
  };
}

const useGetInstances = () => {
  return useQuery<GetInstancesResponse>({
    queryFn: async () => {
      const res = await GET<GetInstancesResponse>({ route: GetRoutes.GetInstances });
      return res;
    },
    queryKey: [GetRoutes.GetInstances],
  });
};

export default useGetInstances;
