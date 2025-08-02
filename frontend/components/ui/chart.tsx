"use client"

import {
  ResponsiveContainer,
  Tooltip,
  TooltipProps,
  BarChart,
  Bar,
  CartesianGrid,
  XAxis,
} from "recharts"
import { ReactElement } from "react"
import { cn } from "@/lib/utils"
import { Card } from "@/components/ui/card"

export type ChartConfig = Record<
  string,
  {
    label: string
    color: string
  }
>

interface ChartContainerProps {
  children: ReactElement
  className?: string
  config: ChartConfig
}

export function ChartContainer({
  children,
  className,
  config,
}: ChartContainerProps) {
  return (
    <div className={cn("w-full h-[300px]", className)}>
      <ResponsiveContainer width="100%" height="100%">
        {children}
      </ResponsiveContainer>
    </div>
  )
}

interface ChartTooltipProps extends TooltipProps<number, string> {
  config: ChartConfig
  payload?: Array<{ name: string; value: number | string }>
  label?: string
}


export function ChartTooltip({ active, payload, label, config }: ChartTooltipProps) {
  if (!active || !payload || payload.length === 0) return null

  return (
    <ChartTooltipContent>
      <p className="text-sm text-muted-foreground">{label}</p>
      {payload.map((entry, index) => {
        const configEntry = config[entry.name]
        return (
          <div key={index} className="flex items-center gap-2 text-sm">
            <span
              className="inline-block w-2 h-2 rounded-full"
              style={{ backgroundColor: configEntry?.color }}
            />
            <span>{configEntry?.label ?? entry.name}:</span>
            <span className="font-medium ml-auto">{entry.value}</span>
          </div>
        )
      })}
    </ChartTooltipContent>
  )
}

interface ChartTooltipContentProps {
  children: React.ReactNode
  className?: string
  hideLabel?: boolean
}

export function ChartTooltipContent({ children, className, hideLabel }: ChartTooltipContentProps) {
  return (
    <Card className={cn("p-4 bg-background border shadow-sm", className)}>
      {!hideLabel && children}
      {/* Se quiser um controle mais customizado, pode usar hideLabel para mostrar/ocultar o label */}
    </Card>
  )
}