import { POST } from "@/lib/api";
import { IInstance } from "@/types";
import { PostRoutes } from "@/types/api/PostRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface CreateInstanceData {
  name: string;
  phone: string;
  platform: 'whatsapp' | 'telegram' | 'instagram';
}

interface CreateInstanceResponse {
  instance: IInstance;
}

const useCreateInstance = () => {
  const queryClient = useQueryClient();

  return useMutation<CreateInstanceResponse, Error, CreateInstanceData>({
    mutationFn: async (data: CreateInstanceData) => {
      const res = await POST<CreateInstanceResponse>({
        route: PostRoutes.CreateInstance,
        body: data,
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetInstances] });
    },
  });
};

export default useCreateInstance;
