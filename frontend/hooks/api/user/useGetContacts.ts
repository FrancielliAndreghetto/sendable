import { GET } from "@/lib/api";
import { IContact } from "@/types";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useQuery } from "@tanstack/react-query";

interface GetContactsResponse {
  success: boolean;
  message: string;
  data: IContact[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    next_page_url: string | null;
    prev_page_url: string | null;
  };
}

const useGetContacts = () => {
  return useQuery<GetContactsResponse>({
    queryFn: async () => {
      const res = await GET<GetContactsResponse>({ route: GetRoutes.GetContacts });
      return res;
    },
    queryKey: [GetRoutes.GetContacts],
  });
};

export default useGetContacts;
